<?php

namespace App\Services;

use App\Models\ReferralEarning;
use App\Models\Shop;

class ReferralService
{
    /**
     * Process referral commission for a new subscription payment.
     */
    public function processCommission(Shop $shop, float $paymentAmount)
    {
        // 1. Check if the shop has a referrer
        if (! $shop->referral_partner_id) {
            return; // No referrer, no commission
        }

        $partner = $shop->partner;
        if (! $partner || $partner->status !== 'active') {
            return; // Partner deleted or suspended
        }

        // 2. Check Duration/Limit Logic
        if ($partner->duration_type === 'one_time') {
            // Only commission on the VERY FIRST payment/subscription
            if ($shop->referral_commission_count >= 1) {
                return;
            }
        } elseif ($partner->duration_type === 'limited') {
            // Commission only up to 'duration_limit' times
            if ($shop->referral_commission_count >= $partner->duration_limit) {
                return;
            }
        }
        // If 'forever', we just proceed.

        // 3. Calculate Amount
        $commissionAmount = 0;

        if ($partner->commission_type === 'fixed') {
            $commissionAmount = $partner->commission_value;
        } else {
            // Percentage
            $commissionAmount = ($paymentAmount * $partner->commission_value) / 100;
        }

        // 4. Record Earning
        if ($commissionAmount > 0) {
            ReferralEarning::create([
                'referral_partner_id' => $partner->id,
                'amount' => $commissionAmount,
                'order_amount' => $paymentAmount,
                'status' => 'unpaid',
            ]);

            // 5. Update Shop Stats
            $shop->increment('referral_commission_count');
        }
    }
}
