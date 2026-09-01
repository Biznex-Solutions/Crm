<?php

namespace Database\Seeders;

use App\Models\CategoryTarget;
use Illuminate\Database\Seeder;

class CategoryTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Real Estate',
                'description' => 'Commercial and residential property sales, leasing, and development targets.',
                'target_deals' => 50,
                'status' => 'active',
            ],
            [
                'name' => 'Travel Companies',
                'description' => 'Tour operators, travel agencies, ticketing, and vacation packages.',
                'target_deals' => 35,
                'status' => 'active',
            ],
            [
                'name' => 'Hotels & Restaurants',
                'description' => 'Hospitality, luxury resort bookings, catering, and fine dining partnerships.',
                'target_deals' => 40,
                'status' => 'active',
            ],
            [
                'name' => 'Education',
                'description' => 'Schools, universities, online academies, and skill training institutes.',
                'target_deals' => 30,
                'status' => 'active',
            ],
            [
                'name' => 'Manufacturing',
                'description' => 'Industrial goods, machinery supply, raw materials, and factory equipment.',
                'target_deals' => 25,
                'status' => 'active',
            ],
            [
                'name' => 'Transportation',
                'description' => 'Fleet management, cargo transit, vehicle rentals, and city logistics.',
                'target_deals' => 45,
                'status' => 'active',
            ],
            [
                'name' => 'Marble & Granite',
                'description' => 'Natural stone processing, tiles, building facade marble, and exports.',
                'target_deals' => 20,
                'status' => 'active',
            ],
            [
                'name' => 'Construction',
                'description' => 'Civil engineering, infrastructure projects, building contractors, and materials.',
                'target_deals' => 60,
                'status' => 'active',
            ],
            [
                'name' => 'Import & Export Logistics',
                'description' => 'International freight forwarding, customs clearance, shipping, and supply chain.',
                'target_deals' => 50,
                'status' => 'active',
            ],
            [
                'name' => 'Healthcare & Medical',
                'description' => 'Hospitals, pharmaceuticals, medical equipment suppliers, and diagnostic labs.',
                'target_deals' => 30,
                'status' => 'active',
            ],
            [
                'name' => 'IT & Software Solutions',
                'description' => 'Enterprise software, web & app development, cloud infrastructure, and AI tools.',
                'target_deals' => 45,
                'status' => 'active',
            ],
            [
                'name' => 'Automotive & Motors',
                'description' => 'Car dealerships, auto spare parts, vehicle maintenance, and EV tech.',
                'target_deals' => 25,
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            CategoryTarget::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
