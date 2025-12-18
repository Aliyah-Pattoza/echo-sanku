<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin Echo Sanku',
            'email' => 'admin@echosanku.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'balance' => 0,
            'is_active' => true,
        ]);

        UserProfile::create([
            'user_id' => $admin->id,
            'phone' => '081234567890',
            'address' => 'RSUD LDP jeneponto',
            'city' => 'Jeneponto',
            'province' => 'Sulawesi Selatan',
        ]);

        // Create Nasabah Demo
        $nasabah = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'nasabah',
            'balance' => 61500,
            'is_active' => true,
        ]);

        UserProfile::create([
            'user_id' => $nasabah->id,
            'phone' => '081298765432',
            'address' => 'BTN Sanur 2 No. 123',
            'city' => 'Jeneponto',
            'province' => 'Sulawesi Selatan',
        ]);
    }
}