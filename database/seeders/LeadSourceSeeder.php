<?php

namespace Database\Seeders;

use App\Models\LeadSource;
use Illuminate\Database\Seeder;

class LeadSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'name' => 'WhatsApp',
                'icon' => 'fa-brands fa-whatsapp',
                'description' => 'Direct incoming leads via WhatsApp Business API and chat links.',
                'status' => 'active',
            ],
            [
                'name' => 'Facebook',
                'icon' => 'fa-brands fa-facebook',
                'description' => 'Facebook Meta ad campaigns, organic page messages, and lead forms.',
                'status' => 'active',
            ],
            [
                'name' => 'Instagram',
                'icon' => 'fa-brands fa-instagram',
                'description' => 'Instagram DMs, story ads, reels, and influencer promotions.',
                'status' => 'active',
            ],
            [
                'name' => 'Call',
                'icon' => 'fa-solid fa-phone-volume',
                'description' => 'Direct phone calls, inbound hotlines, and telemarketing outreach.',
                'status' => 'active',
            ],
            [
                'name' => 'Website',
                'icon' => 'fa-solid fa-globe',
                'description' => 'Official website contact forms, live chat widget, and landing pages.',
                'status' => 'active',
            ],
            [
                'name' => 'Email Campaign',
                'icon' => 'fa-regular fa-envelope',
                'description' => 'Newsletter signups, cold outreach emails, and drip campaigns.',
                'status' => 'active',
            ],
            [
                'name' => 'Google Ads',
                'icon' => 'fa-brands fa-google',
                'description' => 'Google PPC search ads, display network, and YouTube video ads.',
                'status' => 'active',
            ],
            [
                'name' => 'LinkedIn',
                'icon' => 'fa-brands fa-linkedin',
                'description' => 'B2B LinkedIn outreach, executive networking, and InMail inquiries.',
                'status' => 'active',
            ],
            [
                'name' => 'Referral',
                'icon' => 'fa-solid fa-people-arrows',
                'description' => 'Existing client referrals, partner recommendations, and word of mouth.',
                'status' => 'active',
            ],
            [
                'name' => 'Exhibition / Trade Show',
                'icon' => 'fa-solid fa-handshake',
                'description' => 'Business expos, industry summits, and physical booth contacts.',
                'status' => 'active',
            ],
        ];

        foreach ($sources as $source) {
            LeadSource::updateOrCreate(['name' => $source['name']], $source);
        }
    }
}
