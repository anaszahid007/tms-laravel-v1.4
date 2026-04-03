<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Measurement;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Find the target user and shop
        $user = User::where('email', 'royal@gmail.com')->first();

        if (! $user || ! $user->shop) {
            $this->command->error('User with email royal@gmail.com or their shop not found!');

            return;
        }

        $shop = $user->shop;

        // Define common measurement types and their fields for "normal" measurements
        $normalMeasurementTypes = [
            'shalwar_kameez' => ['length', 'chest', 'waist', 'hips', 'shoulders', 'sleeves', 'collar', 'shalwar_length', 'shalwar_bottom'],
            'pant_coat' => ['coat_length', 'chest', 'waist', 'shoulders', 'sleeves', 'pant_length', 'pant_waist', 'pant_bottom'],
            'shirt' => ['length', 'chest', 'waist', 'shoulders', 'sleeves', 'collar', 'cuff'],
            'trouser' => ['length', 'waist', 'hips', 'thigh', 'bottom'],
        ];

        $this->command->info("Creating 50 customers for shop: {$shop->name} (Normal Measurements)...");

        // 3. Create 50 Customers
        for ($i = 0; $i < 50; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $customer = Customer::create([
                'shop_id' => $shop->id,
                'customer_key' => 'CUST-'.strtoupper(Str::random(8)),
                'name' => $faker->name($gender),
                'phone' => '03'.$faker->numerify('#########'),
                'address' => $faker->address,
                'gender' => $gender,
            ]);

            // 4. Create 1-2 "Normal" Measurements per customer (no template_id)
            $numMeasurements = rand(1, 2);
            for ($m = 0; $m < $numMeasurements; $m++) {
                $type = $faker->randomKey($normalMeasurementTypes);
                $fields = $normalMeasurementTypes[$type];

                $measurementData = [];
                foreach ($fields as $field) {
                    $measurementData[$field] = rand(10, 50).($faker->randomElement(['', '.25', '.5', '.75']));
                }

                Measurement::create([
                    'shop_id' => $shop->id,
                    'customer_id' => $customer->id,
                    'template_id' => null, // Explicitly null for "normal" measurements
                    'type' => $type,
                    'data' => $measurementData,
                    'language' => $faker->randomElement(['en', 'ur']),
                    'notes' => $faker->sentence,
                ]);
            }

            // 5. Create 2-3 Orders per customer
            $numOrders = rand(2, 3);
            for ($o = 0; $o < $numOrders; $o++) {
                $status = $faker->randomElement(['pending', 'in_progress', 'completed', 'delivered']);
                $totalPrice = rand(2000, 10000);
                $advancePayment = rand(500, $totalPrice);
                $remainingAmount = $totalPrice - $advancePayment;

                $startDate = Carbon::now()->subDays(rand(1, 30));
                $deliveryDate = (clone $startDate)->addDays(rand(7, 14));

                Order::create([
                    'shop_id' => $shop->id,
                    'customer_id' => $customer->id,
                    'order_key' => 'ORD-'.strtoupper(Str::random(8)),
                    'status' => $status,
                    'start_date' => $startDate,
                    'delivery_date' => $deliveryDate,
                    'total_price' => $totalPrice,
                    'advance_payment' => $advancePayment,
                    'remaining_amount' => $remainingAmount,
                    'notes' => $faker->sentence,
                ]);
            }
        }

        $this->command->info('✅ Shop data seeded successfully for royal@gmail.com!');
    }
}
