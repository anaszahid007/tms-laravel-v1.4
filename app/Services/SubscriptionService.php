<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Shop;
use App\Models\ShopSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    /**
     * Create a new payment for manual verification
     */
    public function createPayment(Shop $shop, SubscriptionPlan $plan, array $data): Payment
    {
        return DB::transaction(function () use ($shop, $plan, $data) {
            // Create payment record
            $payment = Payment::create([
                'shop_id' => $shop->id,
                'subscription_plan_id' => $plan->id,
                'amount' => $plan->price,
                'currency' => 'PKR',
                'status' => 'pending',
                'payment_proof_path' => $data['payment_proof_path'],
                'transaction_id' => $data['transaction_id'],
                'shop_notes' => $data['shop_notes'] ?? null,
            ]);

            // Create temporary subscription with grace period
            $this->createGracePeriodSubscription($shop, $plan);

            return $payment;
        });
    }

    /**
     * Create a temporary subscription with grace period
     */
    public function createGracePeriodSubscription(Shop $shop, SubscriptionPlan $plan): ShopSubscription
    {
        return DB::transaction(function () use ($shop, $plan) {
            // Deactivate any existing active subscriptions
            $shop->subscriptions()->active()->update([
                'is_active' => false,
                'status' => 'expired',
            ]);

            // Create new subscription with grace period
            return ShopSubscription::create([
                'shop_id' => $shop->id,
                'subscription_plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => now()->addHours(48), // 48-hour grace period
                'grace_period_ends_at' => now()->addHours(48),
                'status' => 'grace',
                'is_active' => true,
                'payment_status' => 'pending',
                'plan_name' => $plan->name,
                'plan_price' => $plan->price,
                'plan_duration_days' => $plan->duration_days,
                'plan_features' => $plan->features,
            ]);
        });
    }

    /**
     * Approve a payment and activate subscription
     */
    public function approvePayment(Payment $payment, User $admin, ?string $adminNotes = null): bool
    {
        return DB::transaction(function () use ($payment, $admin, $adminNotes) {
            try {
                // Update payment status
                $payment->update([
                    'status' => 'approved',
                    'admin_notes' => $adminNotes,
                    'processed_by' => $admin->id,
                    'processed_at' => now(),
                ]);

                // Get the shop and plan
                $shop = $payment->shop;
                $plan = $payment->subscriptionPlan;

                // Deactivate any existing active subscriptions
                $shop->subscriptions()->active()->update([
                    'is_active' => false,
                    'status' => 'expired',
                ]);

                // Find the grace period subscription and update it
                $graceSubscription = $shop->subscriptions()
                    ->where('status', 'grace')
                    ->where('subscription_plan_id', $plan->id)
                    ->latest()
                    ->first();

                if ($graceSubscription) {
                    // Update existing grace subscription
                    $graceSubscription->update([
                        'starts_at' => now(),
                        'ends_at' => now()->addDays($plan->duration_days),
                        'grace_period_ends_at' => now()->addDays($plan->duration_days + 7),
                        'status' => 'active',
                        'payment_status' => 'approved',
                    ]);
                    $newEndDate = $graceSubscription->ends_at;
                } else {
                    // Create new active subscription
                    $subscription = ShopSubscription::create([
                        'shop_id' => $shop->id,
                        'subscription_plan_id' => $plan->id,
                        'starts_at' => now(),
                        'ends_at' => now()->addDays($plan->duration_days),
                        'grace_period_ends_at' => now()->addDays($plan->duration_days + 7),
                        'status' => 'active',
                        'is_active' => true,
                        'payment_status' => 'approved',
                        'plan_name' => $plan->name,
                        'plan_price' => $plan->price,
                        'plan_duration_days' => $plan->duration_days,
                        'plan_features' => $plan->features,
                    ]);
                    $newEndDate = $subscription->ends_at;
                }

                // Process referral commission if applicable
                if ($plan->price > 0) {
                    app(\App\Services\ReferralService::class)->processCommission($shop, $plan->price);
                }

                // Sync with shop table
                $shop->update([
                    'status' => 'active',
                    'subscription_ends_at' => $newEndDate,
                ]);

                return true;
            } catch (\Exception $e) {
                Log::error('Failed to approve payment', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }
        });
    }

    /**
     * Reject a payment
     */
    public function rejectPayment(Payment $payment, User $admin, ?string $reason = null): bool
    {
        return DB::transaction(function () use ($payment, $admin, $reason) {
            // Update payment status
            $payment->update([
                'status' => 'rejected',
                'admin_notes' => $reason,
                'processed_by' => $admin->id,
                'processed_at' => now(),
            ]);

            // Deactivate the grace period subscription
            $shop = $payment->shop;
            $plan = $payment->subscriptionPlan;

            $shop->subscriptions()
                ->where('status', 'grace')
                ->where('subscription_plan_id', $plan->id)
                ->latest()
                ->update([
                    'is_active' => false,
                    'status' => 'expired',
                ]);

            return true;
        });
    }

    /**
     * Check if shop has active subscription
     */
    public function hasActiveSubscription(Shop $shop): bool
    {
        return $shop->subscriptions()->active()->exists();
    }

    /**
     * Get current active subscription for shop
     */
    public function getCurrentSubscription(Shop $shop): ?ShopSubscription
    {
        return $shop->subscriptions()->active()->latest()->first();
    }

    /**
     * Get subscription that grants access: either active or in grace period (e.g. 48h pending approval).
     * Used so shops have temporary access while payment is being verified.
     */
    public function getActiveOrGraceSubscription(Shop $shop): ?ShopSubscription
    {
        $active = $shop->subscriptions()->active()->latest()->first();
        if ($active) {
            return $active;
        }
        $grace = $shop->subscriptions()
            ->where('status', 'grace')
            ->where('is_active', true)
            ->where('grace_period_ends_at', '>', now())
            ->latest()
            ->first();

        return $grace;
    }

    /**
     * Check if subscription is expiring soon
     */
    public function isExpiringSoon(Shop $shop): bool
    {
        $subscription = $this->getCurrentSubscription($shop);

        return $subscription && $subscription->isExpiringSoon();
    }

    /**
     * Check if subscription has expired
     */
    public function hasExpired(Shop $shop): bool
    {
        $subscription = $shop->subscriptions()
            ->where('is_active', true)
            ->latest()
            ->first();

        return $subscription && $subscription->hasExpired();
    }

    /**
     * Create a free subscription
     */
    public function createFreeSubscription(Shop $shop, SubscriptionPlan $plan): ShopSubscription
    {
        return DB::transaction(function () use ($shop, $plan) {
            // Deactivate any existing active subscriptions
            $shop->subscriptions()->active()->update([
                'is_active' => false,
                'status' => 'expired',
            ]);

            // Create new active subscription for free plan
            $subscription = ShopSubscription::create([
                'shop_id' => $shop->id,
                'subscription_plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($plan->duration_days),
                'grace_period_ends_at' => now()->addDays($plan->duration_days + 7),
                'status' => 'active',
                'is_active' => true,
                'payment_status' => 'approved', // Free plans are automatically approved
                'plan_name' => $plan->name,
                'plan_price' => $plan->price,
                'plan_duration_days' => $plan->duration_days,
                'plan_features' => $plan->features,
            ]);

            // Sync with shop table
            $shop->update([
                'status' => 'active',
                'subscription_ends_at' => $subscription->ends_at,
            ]);

            return $subscription;
        });
    }

    /**
     * Get subscription status for shop.
     * Uses getActiveOrGraceSubscription so 48h grace (pending payment) grants access.
     */
    public function getSubscriptionStatus(Shop $shop): array
    {
        $subscription = $this->getActiveOrGraceSubscription($shop);

        if (! $subscription) {
            return [
                'has_subscription' => false,
                'is_active' => false,
                'is_expired' => true,
                'is_expiring_soon' => false,
                'days_until_expiry' => 0,
                'status' => 'no_subscription',
                'subscription' => $subscription,
            ];
        }

        return [
            'has_subscription' => true,
            'is_active' => $subscription->isActive(),
            'is_expired' => $subscription->hasExpired(),
            'is_expiring_soon' => $subscription->isExpiringSoon(),
            'days_until_expiry' => (int) ceil(now()->diffInHours($subscription->ends_at, false) / 24),
            'status' => $subscription->status,
            'subscription' => $subscription,
        ];
    }
}
