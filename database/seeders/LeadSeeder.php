<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\LeadFollowup;
use App\Models\User;
use App\Models\LeadSource;
use App\Models\CategoryTarget;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $sources = LeadSource::all();
        $categories = CategoryTarget::all();

        if ($users->isEmpty() || $sources->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $sampleLeads = [
            [
                'name' => 'Tariq Mehmood',
                'email' => 'tariq.mehmood@gmail.com',
                'phone' => '+92 300 5551234',
                'whatsapp' => '+92 300 5551234',
                'source_name' => 'WhatsApp',
                'category_name' => 'Real Estate',
                'status' => 'won',
                'notes' => 'Interested in purchasing a commercial plot in Gulberg Greens, Islamabad. Budget $150k.',
                'followups' => [
                    ['date' => '2026-08-20', 'status' => 'contacted', 'remarks' => 'Initial WhatsApp conversation. Sent PDF brochure.'],
                    ['date' => '2026-08-23', 'status' => 'in_progress', 'remarks' => 'Site visit conducted with client. Client was impressed with location.'],
                    ['date' => '2026-08-28', 'status' => 'won', 'remarks' => 'Token payment received! Deal closed successfully.'],
                ]
            ],
            [
                'name' => 'Sophia Alvi',
                'email' => 'sophia.alvi@outlook.com',
                'phone' => '+92 321 4448899',
                'whatsapp' => '+92 321 4448899',
                'source_name' => 'Instagram',
                'category_name' => 'Travel Companies',
                'status' => 'in_progress',
                'notes' => 'Inquired about family Europe tour package for 4 adults.',
                'followups' => [
                    ['date' => '2026-08-22', 'status' => 'contacted', 'remarks' => 'Responded to IG DM. Sent customized itinerary & pricing.'],
                    ['date' => '2026-08-26', 'status' => 'in_progress', 'remarks' => 'Adjusted dates and upgraded hotel choices per client request.'],
                ]
            ],
            [
                'name' => 'Dr. Kamran Qureshi',
                'email' => 'kamran@qureshiclinic.com',
                'phone' => '+92 333 7772211',
                'whatsapp' => '+92 333 7772211',
                'source_name' => 'Call',
                'category_name' => 'Hotels & Restaurants',
                'status' => 'contacted',
                'notes' => 'Looking to book a corporate conference hall for medical seminar.',
                'followups' => [
                    ['date' => '2026-08-25', 'status' => 'contacted', 'remarks' => 'Discussed hall capacity, catering menu, and projector setup.'],
                ]
            ],
            [
                'name' => 'Farhan Zaidi',
                'email' => 'farhan@zaiditech.com',
                'phone' => '+92 312 9993344',
                'whatsapp' => '+92 312 9993344',
                'source_name' => 'Facebook',
                'category_name' => 'Education',
                'status' => 'new',
                'notes' => 'Submitted Facebook lead ad form for Executive Leadership Masterclass.',
                'followups' => []
            ],
            [
                'name' => 'Malik Usman',
                'email' => 'usman@malikconstructions.com',
                'phone' => '+92 301 8882233',
                'whatsapp' => '+92 301 8882233',
                'source_name' => 'WhatsApp',
                'category_name' => 'Construction',
                'status' => 'won',
                'notes' => 'Bulk procurement of cement and steel rebar for high-rise building.',
                'followups' => [
                    ['date' => '2026-08-15', 'status' => 'contacted', 'remarks' => 'Shared rate list and credit terms.'],
                    ['date' => '2026-08-25', 'status' => 'won', 'remarks' => 'Purchase order signed for 500 metric tons.'],
                ]
            ],
            [
                'name' => 'Noman Sheikh',
                'email' => 'noman@sheikhtraders.com',
                'phone' => '+92 345 6667788',
                'whatsapp' => '+92 345 6667788',
                'source_name' => 'Call',
                'category_name' => 'Import & Export Logistics',
                'status' => 'lost',
                'notes' => 'Container freight forwarding from Karachi port to Rotterdam.',
                'followups' => [
                    ['date' => '2026-08-10', 'status' => 'contacted', 'remarks' => 'Quoted $4,200 per 40ft container.'],
                    ['date' => '2026-08-14', 'status' => 'lost', 'remarks' => 'Client went with competitor due to lower shipping rate.'],
                ]
            ],
            [
                'name' => 'Zuhair Arshad',
                'email' => 'zuhair@arshadmarble.com',
                'phone' => '+92 315 3334455',
                'whatsapp' => '+92 315 3334455',
                'source_name' => 'Website',
                'category_name' => 'Marble & Granite',
                'status' => 'in_progress',
                'notes' => 'Requesting sample slabs of Italian Botticino marble.',
                'followups' => [
                    ['date' => '2026-08-27', 'status' => 'in_progress', 'remarks' => 'Sent sample tiles via courier. Awaiting feedback.'],
                ]
            ],
            [
                'name' => 'Sadia Rizvi',
                'email' => 'sadia.rizvi@gmail.com',
                'phone' => '+92 334 1112233',
                'whatsapp' => '+92 334 1112233',
                'source_name' => 'Instagram',
                'category_name' => 'Real Estate',
                'status' => 'new',
                'notes' => 'Asked for price list of 1-bed luxury apartments in DHA Phase 8.',
                'followups' => []
            ],
        ];

        $userIndex = 0;
        foreach ($sampleLeads as $data) {
            $user = $users[$userIndex % $users->count()];
            $source = $sources->firstWhere('name', $data['source_name']) ?? $sources->first();
            $category = $categories->firstWhere('name', $data['category_name']) ?? $categories->first();

            $lead = Lead::create([
                'user_id' => $user->id,
                'lead_source_id' => $source->id,
                'category_target_id' => $category->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'whatsapp' => $data['whatsapp'],
                'status' => $data['status'],
                'notes' => $data['notes'],
            ]);

            foreach ($data['followups'] as $f) {
                LeadFollowup::create([
                    'lead_id' => $lead->id,
                    'user_id' => $user->id,
                    'followup_date' => $f['date'],
                    'status' => $f['status'],
                    'remarks' => $f['remarks'],
                ]);
            }

            $userIndex++;
        }
    }
}
