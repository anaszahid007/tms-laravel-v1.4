<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admin
        if (! User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'phone' => '03001234567',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'shop_id' => null,
                'remember_token' => Str::random(10),
            ]);
        }

        // Dummy Shops Data
        $shopsData = [
            [
                'name' => 'The Royal Stitch',
                'owner_name' => 'Ahmed Khan',
                'email' => 'royal@gmail.com',
                'phone' => '03125556677',
                'status' => 'active',
                'sub_days' => 30,
            ],
            [
                'name' => 'Golden Needle',
                'owner_name' => 'Sajid Mehmood',
                'email' => 'golden@gmail.com',
                'phone' => '03214443322',
                'status' => 'trial',
                'sub_days' => 7,
            ],
            [
                'name' => 'Classic Fits',
                'owner_name' => 'Mohammad Ali',
                'email' => 'classic@gmail.com',
                'phone' => '03331112233',
                'status' => 'expired',
                'sub_days' => -2, // Already expired
            ],
        ];

        foreach ($shopsData as $data) {
            if (User::where('email', $data['email'])->exists()) {
                continue;
            }

            // Create Owner
            $user = User::create([
                'name' => $data['owner_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'shop',
                'remember_token' => Str::random(10),
            ]);

            // Create Shop
            $shop = Shop::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'shop_key' => 'SHOP-'.strtoupper(Str::random(8)),
                'status' => $data['status'],
                'subscription_ends_at' => now()->addDays($data['sub_days']),
            ]);

            // Link User to Shop
            $user->update(['shop_id' => $shop->id]);
        }
    }
}
