<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'TailorOnDesk',
            'contact_phone' => '0339842374834',
            'contact_email' => 'admin@tailorondesk.com',
            'maintenance_mode' => 'false',
            'allow_registration' => 'true',
        ];

        foreach ($settings as $key => $value) {
            $type = 'string';
            if ($value === 'true' || $value === 'false') {
                $type = 'boolean';
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => $type]
            );
        }
    }
}
