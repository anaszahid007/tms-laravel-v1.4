<?php

namespace Database\Seeders;

use App\Models\ShopSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ShopSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get available plans from seeder
        $freeTrialPlan = SubscriptionPlan::where('slug', 'free-trial')->first();
        $monthlyBasicPlan = SubscriptionPlan::where('slug', 'monthly-basic')->first();
        $premiumPlan = SubscriptionPlan::where('slug', 'premium')->first();

        // Get users with shops (role = 'shop')
        $shopUsers = User::where('role', 'shop')->whereNotNull('shop_id')->get();

        if ($shopUsers->isEmpty()) {
            $this->command->warn('⚠️  No shop users found with linked shops. Please run UserSeeder first.');
            return;
        }

        $subscriptions = [];

        // Subscribe users to different plans
        foreach ($shopUsers as $index => $user) {
            $plan = null;
            $startsAt = null;
            $endsAt = null;
            $status = 'active';
            $paymentStatus = 'approved';

            // Cycle through available plans
            switch ($index % 3) {
                case 0:
                    // Free trial - active
                    $plan = $freeTrialPlan;
                    $startsAt = Carbon::now()->subDays(2);
                    $endsAt = Carbon::now()->addDays(5);
                    break;
                case 1:
                    // Monthly Basic - active
                    $plan = $monthlyBasicPlan;
                    $startsAt = Carbon::now()->subDays(10);
                    $endsAt = Carbon::now()->addDays(20);
                    break;
                case 2:
                    // Premium - active
                    $plan = $premiumPlan;
                    $startsAt = Carbon::now()->subDays(5);
                    $endsAt = Carbon::now()->addDays(25);
                    break;
            }

            if ($plan) {
                ShopSubscription::create([
                    'shop_id' => $user->shop_id,
                    'subscription_plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                    'plan_price' => $plan->price,
                    'plan_duration_days' => $plan->duration_days,
                    'plan_features' => $plan->features,
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'grace_period_ends_at' => $endsAt->copy()->addDays(7),
                    'status' => $status,
                    'is_active' => true,
                    'payment_status' => $paymentStatus,
                    'transaction_id' => 'TXN-' . strtoupper(\Illuminate\Support\Str::random(10)),
                ]);

                $subscriptions[] = "[Shop: {$user->shop->name}] → [Plan: {$plan->name}]";
            }
        }

        // Add an expired subscription for testing
        $expiredShopUser = $shopUsers->last();
        if ($expiredShopUser && $monthlyBasicPlan) {
             ShopSubscription::create([
                'shop_id' => $expiredShopUser->shop_id,
                'subscription_plan_id' => $monthlyBasicPlan->id,
                'plan_name' => $monthlyBasicPlan->name,
                'plan_price' => $monthlyBasicPlan->price,
                'plan_duration_days' => $monthlyBasicPlan->duration_days,
                'plan_features' => $monthlyBasicPlan->features,
                'starts_at' => Carbon::now()->subDays(40),
                'ends_at' => Carbon::now()->subDays(10),
                'grace_period_ends_at' => Carbon::now()->subDays(3),
                'status' => 'expired',
                'is_active' => false,
                'payment_status' => 'approved',
                'transaction_id' => 'TXN-EXPIRED-' . strtoupper(\Illuminate\Support\Str::random(6)),
            ]);
            $subscriptions[] = "[Shop: {$expiredShopUser->shop->name}] → [Plan: {$monthlyBasicPlan->name}] (EXPIRED)";
        }

        $this->command->info('✅ Shop subscriptions created successfully!');
        foreach ($subscriptions as $sub) { $this->command->line('   - ' . $sub); }
    }
}
