<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'price' => 0.00,
                'discount_percentage' => 0,
                'duration_days' => 7,
                'description' => 'Try Tailor On Desk risk-free for 7 days. No credit card required.',
                'features' => [
                    'Up to 50 customers',
                    'Unlimited orders',
                    'Basic measurements',
                    'Email support',
                    '7-day trial period',
                    'No credit card required',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Monthly Basic',
                'slug' => 'monthly-basic',
                'price' => 2999.00, // PKR
                'discount_percentage' => 0,
                'duration_days' => 30,
                'description' => 'Perfect for small tailor shops. Billed monthly.',
                'features' => [
                    'Unlimited customers',
                    'Unlimited orders',
                    'Advanced measurements',
                    'Priority email support',
                    'Basic reports',
                    'Customer search & history',
                    'Order status tracking',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'price' => 4499.00, // PKR
                'discount_percentage' => 0,
                'duration_days' => 30,
                'description' => 'For established shops that need advanced features. Billed monthly.',
                'features' => [
                    'Everything in Monthly Basic',
                    'SMS notifications',
                    'Advanced analytics',
                    '24/7 priority support',
                    'Custom branding',
                    'API access',
                    'WhatsApp integration',
                    'Bulk order operations',
                ],
                'is_active' => true,
            ],
            // [
            //     'name' => 'Yearly Basic',
            //     'slug' => 'yearly-basic',
            //     'price' => 29999.00, // PKR (Save 17% - PKR 2,999 * 12 = 35,988 vs 29,999)
            //     'discount_percentage' => 17,
            //     'duration_days' => 365,
            //     'description' => 'Save 17% with annual billing. All Monthly Basic features included.',
            //     'features' => [
            //         'Everything in Monthly Basic',
            //         'Annual billing - Save 17%',
            //         'Priority onboarding',
            //         'Quarterly business reviews',
            //     ],
            //     'is_active' => true,
            // ],
            // [
            //     'name' => 'Yearly Premium',
            //     'slug' => 'yearly-premium',
            //     'price' => 44999.00, // PKR (Save 17% - PKR 4,499 * 12 = 53,988 vs 44,999)
            //     'discount_percentage' => 17,
            //     'duration_days' => 365,
            //     'description' => 'Maximum value for power users. Save 17% with annual billing.',
            //     'features' => [
            //         'Everything in Premium',
            //         'Annual billing - Save 17%',
            //         'Dedicated account manager',
            //         'Custom feature development',
            //         'Advanced security features',
            //         'Data export & backups',
            //     ],
            //     'is_active' => true,
            // ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }

        $this->command->info('✅ Subscription plans seeded successfully!');
    }
}
