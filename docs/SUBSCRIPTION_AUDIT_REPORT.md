# Subscription Implementation Audit Report

**Project:** TailorOnDesk v1.3  
**Audit Date:** March 1, 2025  
**Reference:** User-provided implementation prompt (SaaS subscription system)

This report compares the current implementation against the prompt requirements. **No code was modified** during this audit.

---

## Executive Summary

| Phase | Status | Critical Issues |
|-------|--------|-----------------|
| Phase 1 – Subscription Plan Management | ✅ Complete | None |
| Phase 2 – shop_subscriptions Architecture | ✅ Complete | None |
| Phase 3 – Manual Payment Workflow | ⚠️ Mostly Complete | **1 Critical:** 48h grace access broken |
| Phase 4 – Expiry Warning System | ⚠️ Partial | Warning banner not global |
| Phase 5 – Soft-Lock Enforcement | ❌ Incorrect | Wrong allow/block logic |

**Overall:** The core payment flow and subscription architecture are solid, but **three areas need fixes** for full prompt compliance and correct user experience.

---

## Phase 1 – Subscription Plan Management (Admin Side)

### Requirements vs Implementation

| Requirement | Status | Notes |
|-------------|--------|-------|
| Create new subscription plans | ✅ | SubscriptionPlanController::store |
| Edit price, duration_days, features | ✅ | SubscriptionPlanController::update |
| Activate/deactivate via is_active | ✅ | `$request->has('is_active')` in store/update |
| Deactivated plans not selectable by shops | ✅ | SubscriptionController filters `where('is_active', true)` |
| Existing subscriptions NOT modified when plan changes | ✅ | Plan snapshot (plan_name, plan_price, etc.) stored in shop_subscriptions |
| duration_days only affects future subscriptions | ✅ | Copied at subscription creation time |

**Verdict:** ✅ **Complete.** No changes needed.

---

## Phase 2 – shop_subscriptions Architecture

### Requirements vs Implementation

| Requirement | Status | Notes |
|-------------|--------|-------|
| shop_subscriptions as source of truth | ✅ | CheckSubscription uses SubscriptionService → ShopSubscription |
| Table: id, shop_id, subscription_plan_id, starts_at, ends_at, grace_period_ends_at, status, is_active | ✅ | Migration matches |
| status: active, grace, expired, pending_payment | ✅ | Enum in migration |
| Do NOT calculate expiry dynamically | ✅ | ends_at persisted; duration_days used only at creation |
| On approval: ends_at = now() + duration_days, persisted | ✅ | SubscriptionService::approvePayment |
| duration_days as template only | ✅ | Plan snapshot stored in subscription |
| FK constraints, indexing | ✅ | shop_id, ends_at, status indexed |

**Verdict:** ✅ **Complete.** Architecture is correct.

---

## Phase 3 – Manual Payment Workflow

### Shop Owner Flow

| Requirement | Status | Notes |
|-------------|--------|-------|
| Select active plan | ✅ | SubscriptionController::checkout filters is_active |
| Upload receipt | ✅ | Validated as image, stored in payment_proofs |
| Create payment (status=pending, shop_id, plan_id) | ✅ | SubscriptionService::createPayment |
| Extend grace by +48 hours (temporary access) | ❌ **BROKEN** | See Critical Issue #1 below |

### Admin Flow

| Requirement | Status | Notes |
|-------------|--------|-------|
| PaymentResource / Custom Approve action | ✅ | PaymentController (Blade, not Filament – acceptable) |
| Approval: DB transaction | ✅ | SubscriptionService::approvePayment |
| Update payment = approved | ✅ | |
| Create/update shop_subscriptions with correct dates | ✅ | starts_at, ends_at, grace_period_ends_at, status, is_active |
| Prevent double approval | ✅ | PaymentController checks `if ($payment->status !== 'pending')` |
| Prevent duplicate active subscriptions | ✅ | Deactivates existing subscriptions before approval |
| Race conditions | ✅ | Wrapped in DB::transaction |

### Critical Issue #1: 48-Hour Grace Period Does Not Grant Access

**Problem:** When a shop submits payment proof, `createGracePeriodSubscription` creates a ShopSubscription with `status=grace` and `grace_period_ends_at = now()->addHours(48)`. The prompt says: *"Immediately extend grace_period_ends_at by +48 hours (temporary access while waiting for approval)"*.

**Current behavior:** `getCurrentSubscription()` and `getSubscriptionStatus()` use `scopeActive()`, which only returns subscriptions where `status='active'`. A subscription with `status='grace'` is **never** returned. So:

- `getSubscriptionStatus()` returns `has_subscription: false`, `is_expired: true`
- CheckSubscription middleware redirects the user to the subscription page for any route except the allowed list
- **Result:** The shop does **not** get 48 hours of access during payment verification. They are effectively locked out until admin approves.

**Expected behavior:** During the 48h grace (pending approval), the shop should have full access to dashboard, customers, orders, measurements, etc.

**Fix:** Extend subscription status logic to treat `status=grace` with `grace_period_ends_at > now()` as valid access. For example:
- Add a method like `getActiveOrGraceSubscription()` that returns either an active subscription or a grace subscription (when grace_period_ends_at > now)
- Use this in `getSubscriptionStatus()` so `is_expired` is false when the shop has a valid grace subscription

---

## Phase 4 – Expiry Warning System

### Requirements vs Implementation

| Requirement | Status | Notes |
|-------------|--------|-------|
| ends_at - now() <= 5 days → Show warning banner | ✅ | isExpiringSoon() uses 5 days; banner exists |
| Within grace_period → Stronger warning | ✅ | Orange banner on subscription page |
| Expired → Soft-lock | ⚠️ | See Phase 5 |
| Lightweight check | ✅ | Single query via getSubscriptionStatus |
| No admin routes | ✅ | CheckSubscription skips admin.* |
| No auth interference | ✅ | Skips auth routes, unauthenticated |
| ShopScope isolation | ✅ | Uses shop from auth user |

### Gap: Warning Banner Not Global

**Prompt:** *"If ends_at - now() <= 5 days → Show warning banner"*

**Current:** Warning banners (expiring soon, grace period) appear **only** on `resources/views/shop/subscriptions/index.blade.php`. The shop layout (`layouts/shop.blade.php`) does **not** include a global banner.

**Result:** Users on customers, orders, dashboard, etc. do not see the expiry warning until they visit the subscription page.

**Fix:** Add a global subscription warning banner to `layouts/shop.blade.php` (or a shared partial) that shows when `subscriptionStatus['is_expiring_soon']` or `subscriptionStatus['subscription']->status === 'grace'`, using the already-shared `subscriptionStatus` from CheckSubscription middleware.

### Scheduler (Optional)

| Requirement | Status | Notes |
|-------------|--------|-------|
| Email 3 days before expiry | ✅ | CheckSubscriptionExpiry command; sends SubscriptionExpiringSoon |
| Scheduler runs | ✅ | console.php: daily + hourly |

**Verdict:** ✅ Scheduler is correct. Prompt said 3 days; implementation uses 3 days.

---

## Phase 5 – Soft-Lock Enforcement

### Requirements vs Implementation

**Prompt:** When `now() > grace_period_ends_at`:

- **Allow:** Viewing customers, Viewing orders, Dashboard access  
- **Block:** Creating orders, Creating customers, Creating new measurements  

**Current implementation:** CheckSubscription uses a single `allowedExpiredRoutes` list. If expired and route **not** in the list → redirect to subscription page.

**Current allowed routes:**
- `dashboard`
- `shop.subscriptions.index`, `shop.subscriptions.checkout`, `shop.subscriptions.store`
- `shop.profile.edit`, `shop.profile.update`, `shop.profile.destroy`, `shop.profile.shop.update`, `shop.password.update`

**Missing from allowed routes:**
- `customers.index`, `customers.show` (viewing customers)
- `orders.index`, `orders.show` (viewing orders)
- `measurements.index`, `measurements.show` (viewing measurements)

**Result:** When expired, users are **redirected** when trying to view customers, orders, or measurements. The prompt says these should be **allowed**.

**Fix:** Add the following to `allowedExpiredRoutes`:
- `customers.index`, `customers.show`
- `orders.index`, `orders.show`
- `measurements.index`, `measurements.show`

And ensure **create/store** routes remain **not** in the list (so they stay blocked):
- `customers.create`, `customers.store`
- `orders.create`, `orders.store`
- `measurements.create`, `measurements.store`

**Additional routes to consider:** `customers.edit`, `customers.update`, `customers.destroy`, `measurements.edit`, `measurements.update`, `orders.edit`, `orders.update`, `orders.bulk-status`, `orders.bulk-fulfill`, `customers.measurements.edit`, `measurements.template-columns`. The prompt says "Creating" is blocked; editing existing data is a gray area. Recommend keeping edit/update blocked for consistency with soft-lock intent, unless you explicitly want to allow edits.

---

## Architecture Standards

| Standard | Status |
|----------|--------|
| duration_days = template, ends_at = actual state | ✅ |
| No dynamic expiry calculation per request | ✅ |
| Stored timestamps | ✅ |
| FK constraints | ✅ |
| Indexing on shop_id, ends_at | ✅ |
| DB transactions for approval | ✅ |
| Code style preserved | ✅ |

---

## Critical Constraints

| Constraint | Status |
|------------|--------|
| No breaking changes to Orders, Customers | ✅ |
| No ShopScope removal | ✅ |
| No cross-tenant data leakage | ✅ |
| Tenant isolation preserved | ✅ |

---

## Tech Stack Note

**Prompt:** *"Admin panel built with Filament"*  
**Implementation:** Admin uses Blade views and standard controllers (SubscriptionPlanController, PaymentController), not Filament.

**Assessment:** No functional impact. The payment approval flow and plan management work correctly. Filament is optional; Blade implementation is acceptable.

---

## Summary of Required Fixes

| Priority | Issue | Location | Action |
|----------|------|----------|--------|
| **P0** | 48h grace does not grant access | SubscriptionService, getSubscriptionStatus | Treat grace status as valid access when grace_period_ends_at > now |
| **P1** | Soft-lock blocks viewing | CheckSubscription middleware | Add customers.index/show, orders.index/show, measurements.index/show to allowedExpiredRoutes |
| **P2** | Warning banner not global | layouts/shop.blade.php | Add global subscription warning banner |

---

## Edge Cases Handled

- ✅ Double approval (payment status check)
- ✅ Duplicate active subscriptions (deactivate before create)
- ✅ Race conditions (DB transaction)
- ✅ Deactivated plans not shown to shops
- ✅ Plan changes not affecting existing subscriptions
- ✅ Admin routes skipped
- ✅ Auth routes skipped

---

## Risk Areas (Post-Fix)

1. **Dual subscription logic:** EnsureShopIsActive still uses Shop.subscription_ends_at. CheckSubscription uses ShopSubscription. If new users get only trial (Shop) and no ShopSubscription, they may be treated as expired. Confirm this is intentional.
2. **Grace vs active:** After fixing P0, ensure grace (48h pending) and grace (post-expiry 7 days) are both handled correctly. The current `status=grace` is used for both. Consider distinguishing if needed (e.g. `pending_approval` vs `grace`).
3. **ShopSubscription BelongsToShop:** When cron runs without a user, ShopScope does not apply (Auth::hasUser() false). Correct for admin/cron. Ensure no admin or background jobs ever query ShopSubscription with an unintended shop context.

---

## Suggested Future Improvements (from prompt)

- Subscription history view
- Upgrade/downgrade handling
- Revenue reporting
- Coupon system

---

*End of audit report.*
