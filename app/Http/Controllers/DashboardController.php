<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\CategoryTarget;
use App\Models\LeadSource;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->isAdmin()) {
            // Global Overview Stats for Admin
            $stats = [
                'total_leads' => Lead::count(),
                'won_deals' => Lead::where('status', 'won')->count(),
                'new_leads' => Lead::where('status', 'new')->count(),
                'in_progress_leads' => Lead::where('status', 'in_progress')->count(),
                'total_users' => User::count(),
                'active_users' => User::where('status', 'active')->count(),
            ];

            // All Users Performance Breakdown for Admin
            $userLeadStats = User::query()
                ->withCount([
                    'leads',
                    'leads as new_count' => function ($query) {
                        $query->where('status', 'new');
                    },
                    'leads as contacted_count' => function ($query) {
                        $query->where('status', 'contacted');
                    },
                    'leads as in_progress_count' => function ($query) {
                        $query->where('status', 'in_progress');
                    },
                    'leads as won_count' => function ($query) {
                        $query->where('status', 'won');
                    },
                    'leads as lost_count' => function ($query) {
                        $query->where('status', 'lost');
                    },
                ])
                ->latest()
                ->get();

            $recentLeads = Lead::with(['user', 'leadSource', 'categoryTarget'])->latest()->take(5)->get();
        } else {
            // Personal Overview Stats for Employee
            $userLeadsQuery = Lead::where('user_id', $currentUser->id);

            $stats = [
                'total_leads' => (clone $userLeadsQuery)->count(),
                'won_deals' => (clone $userLeadsQuery)->where('status', 'won')->count(),
                'new_leads' => (clone $userLeadsQuery)->where('status', 'new')->count(),
                'in_progress_leads' => (clone $userLeadsQuery)->where('status', 'in_progress')->count(),
            ];

            $userLeadStats = null;
            $recentLeads = (clone $userLeadsQuery)->with(['user', 'leadSource', 'categoryTarget'])->latest()->take(5)->get();
        }

        return view('dashboard', compact('stats', 'userLeadStats', 'recentLeads'));
    }
}
