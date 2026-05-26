<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administratorius', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'support@example.com'],
            ['name' => 'Palaikymo specialistas', 'password' => Hash::make('password'), 'role' => 'support']
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'Paprastas vartotojas', 'password' => Hash::make('password'), 'role' => 'user']
        );

        $this->call([
            CategorySeeder::class,
            SettingSeeder::class,
        ]);
    }
}