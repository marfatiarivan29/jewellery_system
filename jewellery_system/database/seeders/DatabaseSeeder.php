<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Default Settings
        Setting::insert([
            ['key' => 'gold_rate_24k', 'value' => '7200', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'gold_rate_22k', 'value' => '6800', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'silver_rate', 'value' => '80', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'shop_name', 'value' => 'My Jewellery Shop', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Categories
        Category::insert([
            ['name' => 'Ring', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Necklace', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bracelet', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Earring', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
