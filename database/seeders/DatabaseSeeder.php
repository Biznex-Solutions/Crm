<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call Category & Lead Source Seeders first
        $this->call([
            CategoryTargetSeeder::class,
            LeadSourceSeeder::class,
        ]);

        $realEstate = \App\Models\CategoryTarget::where('name', 'Real Estate')->first();
        $travel = \App\Models\CategoryTarget::where('name', 'Travel Companies')->first();
        $hotels = \App\Models\CategoryTarget::where('name', 'Hotels & Restaurants')->first();
        $construction = \App\Models\CategoryTarget::where('name', 'Construction')->first();
        $marble = \App\Models\CategoryTarget::where('name', 'Marble & Granite')->first();

        // System Admin User
        User::create([
            'name' => 'Biznex Admin',
            'email' => 'admin@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '+92 318 1033759',
            'designation' => 'System Administrator',
        ]);

        // Requested Employee Users with assigned target categories
        User::create([
            'name' => 'Syeda Tehreema',
            'email' => 'tehreema@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'category_target_id' => $realEstate?->id,
            'status' => 'active',
            'phone' => '+92 300 1122334',
            'designation' => 'Senior Sales Consultant',
        ]);

        User::create([
            'name' => 'Abrahim Daniyal',
            'email' => 'abrahim@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'category_target_id' => $travel?->id,
            'status' => 'active',
            'phone' => '+92 321 4455667',
            'designation' => 'Business Development Executive',
        ]);

        User::create([
            'name' => 'Muhammad Noman',
            'email' => 'noman@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'category_target_id' => $hotels?->id,
            'status' => 'active',
            'phone' => '+92 333 7788990',
            'designation' => 'Lead Acquisition Specialist',
        ]);

        User::create([
            'name' => 'Subhan Abdullah',
            'email' => 'subhan@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'category_target_id' => $construction?->id,
            'status' => 'active',
            'phone' => '+92 312 9900112',
            'designation' => 'Account Executive',
        ]);

        User::create([
            'name' => 'Abdul Rehman Alvi',
            'email' => 'abdulrehman@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'category_target_id' => $marble?->id,
            'status' => 'active',
            'phone' => '+92 345 2233445',
            'designation' => 'Client Relationship Manager',
        ]);

        // Call Lead Seeder
        $this->call([
            LeadSeeder::class,
        ]);
    }
}
