<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CategoryTarget;
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

        $realEstate = CategoryTarget::where('name', 'Real Estate')->first();
        $travel = CategoryTarget::where('name', 'Travel Companies')->first();
        $hotels = CategoryTarget::where('name', 'Hotels & Restaurants')->first();
        $construction = CategoryTarget::where('name', 'Construction')->first();
        $marble = CategoryTarget::where('name', 'Marble & Granite')->first();
        $education = CategoryTarget::where('name', 'Education')->first();
        $logistics = CategoryTarget::where('name', 'Import & Export Logistics')->first();

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

        // Requested Employee Users with multiple assigned target categories
        $emp1 = User::create([
            'name' => 'Syeda Tehreema',
            'email' => 'tehreema@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'status' => 'active',
            'phone' => '+92 300 1122334',
            'designation' => 'Senior Sales Consultant',
        ]);
        $emp1->categoryTargets()->sync(array_filter([$realEstate?->id, $construction?->id]));

        $emp2 = User::create([
            'name' => 'Abrahim Daniyal',
            'email' => 'abrahim@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'status' => 'active',
            'phone' => '+92 321 4455667',
            'designation' => 'Business Development Executive',
        ]);
        $emp2->categoryTargets()->sync(array_filter([$travel?->id, $hotels?->id]));

        $emp3 = User::create([
            'name' => 'Muhammad Noman',
            'email' => 'noman@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'status' => 'active',
            'phone' => '+92 333 7788990',
            'designation' => 'Lead Acquisition Specialist',
        ]);
        $emp3->categoryTargets()->sync(array_filter([$hotels?->id, $education?->id]));

        $emp4 = User::create([
            'name' => 'Subhan Abdullah',
            'email' => 'subhan@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'status' => 'active',
            'phone' => '+92 312 9900112',
            'designation' => 'Account Executive',
        ]);
        $emp4->categoryTargets()->sync(array_filter([$construction?->id, $realEstate?->id]));

        $emp5 = User::create([
            'name' => 'Abdul Rehman Alvi',
            'email' => 'abdulrehman@biznex.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'status' => 'active',
            'phone' => '+92 345 2233445',
            'designation' => 'Client Relationship Manager',
        ]);
        $emp5->categoryTargets()->sync(array_filter([$marble?->id, $logistics?->id]));

        // Call Lead Seeder
        $this->call([
            LeadSeeder::class,
        ]);
    }
}
