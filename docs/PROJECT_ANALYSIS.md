# TailorOnDesk v1.3 — Project Analysis

This document provides a structured analysis of the project for safe, conflict-free future changes. **No code was modified** during this analysis.

---

## 1. Project overview

**TailorOnDesk** is a multi-tenant SaaS application for tailor shops. It has three main user-facing areas:

- **Public** — Marketing site (home, pricing, contact, terms, privacy).
- **Shop** — Tailor shop dashboard (customers, measurements, orders, subscriptions).
- **Admin** — Super-admin panel (shops, plans, referrals, payments, templates, reports).

**Tech stack:** Laravel 12, PHP 8.2+, Laravel Breeze (Blade + Alpine.js), Vite 7, Tailwind CSS 3, Axios; optional `stevebauman/location`. Default DB: SQLite (env overridable to MySQL/PostgreSQL). Sessions: database.

---

## 2. Architecture and folder structure

### 2.1 High-level architecture

- **MVC** with clear separation by **role/area**: Public, Shop, Admin.
- **Route groups**: `web.php` → includes `auth.php`, `admin.php`, `shop.php`.
- **Middleware**: Global web stack + aliases `admin`, `subscription`.
- **Multi-tenancy**: Shop-scoped data via `BelongsToShop` trait + `ShopScope` (global scope). Admin and global entities (e.g. `MeasurementTemplate`) are not shop-scoped.

### 2.2 Root structure (relevant parts)

| Path | Purpose |
|------|--------|
| `app/` | Models, Http (Controllers, Middleware, Requests), Services, Jobs, Mail, Traits, Scopes, View/Components |
| `config/` | app, auth, database, session, mail, etc. |
| `database/` | migrations, seeders, factories |
| `resources/` | views (layouts, public, auth, shop, admin), js/css (Vite), Blade components |
| `routes/` | web.php, auth.php, admin.php, shop.php, console.php |
| `bootstrap/app.php` | Routing, middleware registration, alias definitions |

### 2.3 Key app/ areas

- **Models:** User, Shop, Customer, Order, Measurement, MeasurementTemplate, MeasurementColumn, SubscriptionPlan, UserSubscription, ShopSubscription, Payment, ReferralPartner, ReferralEarning, ReferralConversion, ReferralPayout, Visit, ActivityLog, ContactUs, Setting.
- **Controllers:** `Admin\*`, `Shop\*`, `Public\*`, `Auth\*` (Breeze), ProfileController, LanguageController.
- **Services:** SubscriptionService, ReferralService.
- **Middleware:** CheckMaintenanceMode, SetLocale, EnsureShopIsActive, TrackVisitor, TrackReferral; aliased: `admin` (IsAdmin), `subscription` (CheckSubscription).
- **Traits:** BelongsToShop (adds ShopScope + auto-set `shop_id` on create).
- **Scopes:** ShopScope (filters by `Auth::user()->shop_id` when present).

---

## 3. Database structure and relationships

### 3.1 Core entities

- **users** — id (uuid), name, email, phone, password, shop_id (nullable), role (admin|shop), email_verified_at, is_suspended, is_deleted, remember_token, timestamps.
- **shops** — id (uuid), user_id (FK users), name, slug, shop_key (unique), subscription_ends_at, status (active|expired|trial), customers_public, phone, address, referral_partner_id, referral_commission_count, timestamps.  
  **Note:** Code uses `shop->is_suspended` (e.g. EnsureShopIsActive, ShopsController), but no migration in the scanned set adds `is_suspended` to `shops`. If the column is missing, add a migration or fix references.
- **customers** — shop_id, customer_key, name, phone, address, gender (shop-scoped).
- **orders** — shop_id, customer_id, order_key, status (pending|in_progress|completed|delivered), start_date, delivery_date, total_price, advance_payment, remaining_amount, notes.
- **measurements** — shop_id, customer_id, template_id (nullable, FK measurement_templates), data (JSON), type, notes, language.

### 3.2 Subscription and payment

- **subscription_plans** — name, price, duration_days, features, is_active, is_free (and any legacy columns).
- **user_subscriptions** — Legacy: user-level subscription; used by `SubscriptionApprovalController` and ReferralService (legacy).
- **shop_subscriptions** — shop_id, subscription_plan_id, starts_at, ends_at, grace_period_ends_at, status (active|grace|expired|pending_payment), is_active, payment_status, payment_proof_path, transaction_id, admin_notes, expiry_notified_at, plan_name, plan_price, plan_duration_days, plan_features.
- **payments** — shop_id, subscription_plan_id, amount, currency, status, payment_proof_path, transaction_id, shop_notes, admin_notes, processed_by, processed_at.

### 3.3 Referrals and other

- **referral_partners** — name, email, phone, referral_code, commission_type, commission_value, duration_type, duration_limit, status.
- **referral_earnings**, **referral_conversions**, **referral_payouts** — linked to referral_partners and shops.
- **measurement_templates** — type, name, name_urdu, is_active (global, no shop_id).
- **measurement_columns** — measurement_template_id, name, sort_order, is_active.
- **visits**, **activity_logs**, **contact_us**, **settings** — supporting tables.

### 3.4 Important relationships

- User **belongsTo** Shop (user.shop_id); Shop **hasOne** owner (user_id), **hasMany** users.
- Shop **hasMany** customers, orders, measurements, shop_subscriptions, payments; **belongsTo** ReferralPartner.
- Customer **hasMany** measurements, orders. Order **belongsTo** Customer.
- Measurement **belongsTo** Customer, MeasurementTemplate (template_id).
- ShopSubscription **belongsTo** Shop, SubscriptionPlan. Payment **belongsTo** Shop, SubscriptionPlan, User (processed_by).
- Models using **BelongsToShop**: Customer, Order, Measurement, ShopSubscription, Payment. So all queries on these are filtered by current user’s shop_id when authenticated and shop_id is set (ShopScope).

---

## 4. Core business logic

### 4.1 Subscription (two systems)

- **Legacy (UserSubscription + Shop columns)**  
  - Registration sets `Shop.status = 'trial'`, `Shop.subscription_ends_at = now()->addDays(7)`.  
  - `SubscriptionApprovalController` approves **UserSubscription** and updates `Shop.status` and `Shop.subscription_ends_at`.  
  - `ReferralService::processCommissionLegacy(UserSubscription)` uses this path.

- **Current (ShopSubscription + Payment)**  
  - Shop subscribes via `SubscriptionController`: free plan → `SubscriptionService::createFreeSubscription`; paid → upload proof → `SubscriptionService::createPayment` + `createGracePeriodSubscription` (48h grace).  
  - Admin approves in **PaymentController** → `SubscriptionService::approvePayment` (activates ShopSubscription, processes referral via `ReferralService::processCommission(Shop, amount)`).  
  - Reject → `SubscriptionService::rejectPayment` (rejects payment, expires grace subscription).

- **Access control**  
  - **CheckSubscription** (middleware): uses **only** `ShopSubscription` (SubscriptionService). Allows specific routes when expired (e.g. subscription index, checkout, profile, dashboard).  
  - **EnsureShopIsActive**: uses **Shop** fields: `user.is_suspended`, `shop.is_suspended`, `shop.subscription_ends_at`, `shop.status === 'expired'`. So both legacy Shop fields and new ShopSubscription can affect access; expiry logic is split between two middlewares.

### 4.2 Referrals

- **TrackReferral** middleware: `?ref=<code>` sets a 30-day cookie; registration reads cookie and links Shop to ReferralPartner, creates ReferralConversion.
- **ReferralService::processCommission(Shop, amount)** (called on payment approval): checks shop’s referrer, duration (one_time / limited / forever), commission type (fixed vs percentage), creates ReferralEarning, increments `shop.referral_commission_count`.

### 4.3 Measurements

- **MeasurementTemplate** and **MeasurementColumn** are global (admin-managed); no BelongsToShop.
- **Measurement** is shop-scoped; has `template_id` and `data` (JSON). Shops use admin-defined templates to capture customer measurements.

### 4.4 Scheduled task

- **subscriptions:check-expiry** (daily + hourly): finds active `ShopSubscription`; expiring soon (3 days) → send SubscriptionExpiringSoon, set expiry_notified_at; past ends_at → enterGracePeriod + send SubscriptionExpired; past grace_period_ends_at → markAsExpired. Only touches **ShopSubscription**, not `Shop.subscription_ends_at`.

---

## 5. Important flows

### 5.1 User and shop lifecycle

1. **Registration** (if `Setting::get('allow_registration')`): Create User (role=shop) → Create Shop (trial 7 days, slug, shop_key) → optional referral link from cookie → user.shop_id = shop.id → Registered event → redirect to email verification.
2. **After login:** EnsureShopIsActive runs (suspended / expired redirects); then CheckSubscription runs on shop routes (expired → subscription page except allowed routes).
3. **Shop usage:** All shop-scoped models (Customer, Order, Measurement, etc.) get `shop_id` from Auth via ShopScope and BelongsToShop.

### 5.2 Subscription flow (current system)

1. Shop visits subscription index → chooses plan → checkout.  
2. Free plan: `createFreeSubscription` → immediate access.  
3. Paid: upload proof → `createPayment` + `createGracePeriodSubscription` (48h access) → admin sees payment in PaymentController.  
4. Approve: `approvePayment` → update Payment, activate/update ShopSubscription, `ReferralService::processCommission`.  
5. Reject: `rejectPayment` → payment rejected, grace subscription expired.  
6. Cron: `subscriptions:check-expiry` moves ShopSubscriptions through expiring_soon → grace → expired and sends emails.

### 5.3 Data flow (shop-scoped)

- Every request with authenticated shop user: ShopScope applies to Customer, Order, Measurement, Payment, ShopSubscription (all use BelongsToShop).  
- Controllers use same models; no need to pass shop_id manually for those.  
- Admin: no ShopScope (admin user has no shop_id), so admin can list all shops, payments, etc.

---

## 6. Dependencies and configuration

- **composer.json:** laravel/framework ^12.0, laravel/breeze ^2.3, stevebauman/location ^7.6; dev: faker, pint, sail, pail, phpunit.
- **package.json:** Vite, Tailwind, Alpine.js, Axios (and any UI deps).
- **config:** app (timezone Asia/Karachi), auth (web guard, users provider), database (default from env), session (database driver). No API guard in use; all routes are web.

---

## 7. Potential risk areas

These are areas where changes could easily affect other features or create inconsistencies.

1. **Dual subscription logic**  
   - **EnsureShopIsActive** uses `Shop.subscription_ends_at` and `Shop.status`.  
   - **CheckSubscription** and **SubscriptionService** use only `ShopSubscription`.  
   - New paid flow does not update `Shop.subscription_ends_at` (only legacy SubscriptionApprovalController does).  
   - **Risk:** Changing one path without the other can make “expired” or “active” state inconsistent between middlewares. Any change to subscription or access control should consider both.

2. **ShopScope and BelongsToShop**  
   - Any model that uses BelongsToShop is filtered by `Auth::user()->shop_id`.  
   - If a controller or job runs in a context without a shop user (e.g. cron, queue, or admin acting on behalf of a shop), scope may not apply or may be wrong.  
   - **Risk:** Adding BelongsToShop to a model used in admin or background tasks can hide rows or cause wrong filtering. Using the same model without the scope (e.g. `Model::withoutGlobalScope(ShopScope::class)`) must be done explicitly and carefully.

3. **User vs Shop suspension**  
   - `users.is_suspended` and `shop.is_suspended` are both used (EnsureShopIsActive).  
   - **Risk:** If `shops.is_suspended` is missing in DB, runtime errors or unexpected behavior. Confirm schema and add migration if needed. Adding new suspension logic should consider both user and shop.

4. **Referral commission**  
   - Triggered in `SubscriptionService::approvePayment` (ShopSubscription path) and in `SubscriptionApprovalController::approve` (UserSubscription path).  
   - **Risk:** Changing commission rules or adding new subscription paths without calling the appropriate referral logic can under/over pay partners.

5. **SubscriptionApprovalController vs PaymentController**  
   - Pending **UserSubscription** (legacy) vs pending **Payment** (new). Two admin entry points.  
   - **Risk:** Disabling or refactoring one without the other can leave one subscription path unhandled. Clarify which flow is canonical and whether legacy should be deprecated or kept in sync.

6. **Measurement templates**  
   - Global (no shop_id). Measurements reference template_id.  
   - **Risk:** Changing or deleting templates can affect existing Measurement records (template_id nullable; onDelete set null). Consider impact on reporting and display.

7. **Route names in CheckSubscription**  
   - `allowedExpiredRoutes` is a fixed list of route names.  
   - **Risk:** Renaming or adding shop routes that should be allowed when expired requires updating this list or logic.

8. **Middleware order**  
   - Global web: CheckMaintenanceMode → SetLocale → EnsureShopIsActive → TrackVisitor → TrackReferral. Then route-level: auth, verified, admin/subscription.  
   - **Risk:** Changing order can change when redirects (suspended, expired) or tracking run; e.g. EnsureShopIsActive before auth could redirect unauthenticated users incorrectly if it ever relied on user.

9. **Registration and trial**  
   - Trial is 7 days on Shop; no ShopSubscription is created at signup.  
   - **Risk:** CheckSubscription only looks at ShopSubscription, so a new user with only trial (Shop.subscription_ends_at) may be treated as “no subscription” and redirected to subscription page. This may be intended (force subscription after trial) but is a behavioral nuance to be aware of when changing trial or first-login flow.

---

## 8. Summary: how the project works

- **Public** visitors see marketing pages; referral links set a cookie.  
- **Registration** creates a User and a Shop (7-day trial on Shop); referral cookie can link the shop to a ReferralPartner.  
- **Shop users** must be verified and pass EnsureShopIsActive (no user/shop suspension, and for legacy logic no expired Shop status). Then CheckSubscription allows access if there is an active ShopSubscription, or redirects to subscription page except on allowed routes (profile, subscription pages, etc.).  
- **Shops** manage customers, measurements (from global templates), and orders; all scoped by shop_id via BelongsToShop and ShopScope.  
- **Subscriptions** can be free (immediate) or paid (proof upload → 48h grace → admin approval in PaymentController → ShopSubscription active and referral commission). Legacy UserSubscription approval still updates Shop and triggers referral.  
- **Cron** runs subscription expiry (ShopSubscription only): expiring soon email, then grace, then expired.  
- **Admins** manage shops (suspend/activate), subscription plans, measurement templates, referrals, pending payments (and legacy pending subscriptions), bulk email, settings, reports.  
- **Localization** is supported (e.g. Urdu/RTL) via SetLocale and route `lang.switch`.

Use this document when implementing new features or refactors to avoid conflicts with existing functionality and to keep behavior consistent across the two subscription paths and shop-scoped data.
