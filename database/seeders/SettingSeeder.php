<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'system_name'],
            ['value' => 'IT problemų registravimo sistema']
        );

        Setting::updateOrCreate(
            ['key' => 'support_email'],
            ['value' => 'support@test.com']
        );

        Setting::updateOrCreate(
            ['key' => 'report_email'],
            ['value' => 'admin@test.com']
        );
    }
}