<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds for production.
     */
    public function run(): void
    {
        // 1. Seed Settings (Idempotent)
        $this->call(SettingSeeder::class);
        $this->command->info('✅ System settings seeded successfully.');

        // 2. Seed Subscription Plans (Idempotent)
        $this->call(SubscriptionPlanSeeder::class);
        $this->command->info('✅ Subscription plans seeded successfully.');

        // 3. Seed Measurement Templates (Idempotent)
        $this->call(MeasurementTemplatesSeeder::class);
        $this->command->info('✅ Measurement templates seeded successfully.');

        // 4. Seed Super Admin (Configurable via ENV or default)
        $adminEmail = env('ADMIN_EMAIL', 'admin@gmail.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password'); // Important: The user should change this in production!

        if (! User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => $adminEmail,
                'phone' => env('ADMIN_PHONE', '03001234567'),
                'email_verified_at' => now(),
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'shop_id' => null,
                'remember_token' => Str::random(10),
            ]);
            $this->command->info('✅ Super Admin created successfully!');
            $this->command->info("   Email: {$adminEmail}");
            $this->command->info("   Password: (from ADMIN_PASSWORD env variable)");
        } else {
            $this->command->info('Super Admin already exists.');
        }
    }
}
