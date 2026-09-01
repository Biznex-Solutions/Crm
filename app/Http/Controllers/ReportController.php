<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\LeadSource;
use App\Models\CategoryTarget;
use App\Models\LeadFollowup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access. Admin privileges required to view employee reports.');
        }
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $userId = $request->query('user_id');
        $status = $request->query('status');

        $query = Lead::query()->with(['user', 'leadSource', 'categoryTarget', 'followups']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $leads = (clone $query)->latest()->paginate(15)->withQueryString();
        $allMatchedLeads = (clone $query)->get();

        $selectedEmployee = $userId ? User::find($userId) : null;

        $stats = [
            'total' => $allMatchedLeads->count(),
            'won' => $allMatchedLeads->where('status', 'won')->count(),
            'new' => $allMatchedLeads->where('status', 'new')->count(),
            'contacted' => $allMatchedLeads->where('status', 'contacted')->count(),
            'in_progress' => $allMatchedLeads->where('status', 'in_progress')->count(),
            'lost' => $allMatchedLeads->where('status', 'lost')->count(),
            'followups_count' => LeadFollowup::whereIn('lead_id', $allMatchedLeads->pluck('id'))->count(),
        ];

        $users = User::all();

        return view('reports.index', compact('leads', 'stats', 'selectedEmployee', 'users', 'userId', 'status'));
    }

    public function exportCsv(Request $request)
    {
        $this->authorizeAdmin();

        $userId = $request->query('user_id');
        $status = $request->query('status');

        $query = Lead::query()->with(['user', 'leadSource', 'categoryTarget', 'followups']);

        $employeeName = 'All_Employees';
        if ($userId) {
            $query->where('user_id', $userId);
            $emp = User::find($userId);
            if ($emp) {
                $employeeName = preg_replace('/[^A-Za-z0-9_]/', '_', $emp->name);
            }
        }

        if ($status) {
            $query->where('status', $status);
        }

        $leads = $query->latest()->get();

        $filename = "lead_report_{$employeeName}_" . date('Y-m-d') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Microsoft Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // CSV Header Row
            fputcsv($file, [
                'Lead ID',
                'Assigned Employee',
                'Employee Email',
                'Customer Name',
                'Phone Number',
                'WhatsApp Number',
                'Customer Email',
                'Lead Source',
                'Target Category',
                'Lead Status',
                'Total Follow-ups Logged',
                'Created Date',
                'Initial Notes',
            ]);

            // CSV Data Rows
            foreach ($leads as $lead) {
                fputcsv($file, [
                    '#' . $lead->id,
                    $lead->user->name ?? 'Unassigned',
                    $lead->user->email ?? 'N/A',
                    $lead->name,
                    $lead->phone,
                    $lead->whatsapp ?? '',
                    $lead->email ?? '',
                    $lead->leadSource->name ?? 'N/A',
                    $lead->categoryTarget->name ?? 'N/A',
                    strtoupper(str_replace('_', ' ', $lead->status)),
                    $lead->followups->count(),
                    $lead->created_at->format('Y-m-d H:i:s'),
                    $lead->notes ?? '',
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
