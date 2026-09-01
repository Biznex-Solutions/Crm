<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadFollowup;
use App\Models\LeadSource;
use App\Models\CategoryTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $sourceId = $request->query('lead_source_id');
        $categoryId = $request->query('category_target_id');
        $userId = $request->query('user_id');

        $currentUser = Auth::user();
        $query = Lead::query()->with(['user', 'leadSource', 'categoryTarget']);

        // Non-admin employees ONLY see their own assigned leads
        if (!$currentUser->isAdmin()) {
            $query->where('user_id', $currentUser->id);
            $statsBase = Lead::where('user_id', $currentUser->id);
        } else {
            if ($userId) {
                $query->filterUser($userId);
            }
            $statsBase = new Lead();
        }

        $leads = $query
            ->search($search)
            ->filterStatus($status)
            ->filterSource($sourceId)
            ->filterCategory($categoryId)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if (!$currentUser->isAdmin()) {
            $stats = [
                'total' => (clone $statsBase)->count(),
                'new' => (clone $statsBase)->where('status', 'new')->count(),
                'contacted' => (clone $statsBase)->where('status', 'contacted')->count(),
                'in_progress' => (clone $statsBase)->where('status', 'in_progress')->count(),
                'won' => (clone $statsBase)->where('status', 'won')->count(),
                'lost' => (clone $statsBase)->where('status', 'lost')->count(),
            ];
        } else {
            $stats = [
                'total' => Lead::count(),
                'new' => Lead::where('status', 'new')->count(),
                'contacted' => Lead::where('status', 'contacted')->count(),
                'in_progress' => Lead::where('status', 'in_progress')->count(),
                'won' => Lead::where('status', 'won')->count(),
                'lost' => Lead::where('status', 'lost')->count(),
            ];
        }

        $sources = LeadSource::where('status', 'active')->get();
        $categories = CategoryTarget::where('status', 'active')->get();
        $users = User::all();

        return view('leads.index', compact('leads', 'search', 'status', 'sourceId', 'categoryId', 'userId', 'stats', 'sources', 'categories', 'users'));
    }

    public function create()
    {
        $currentUser = Auth::user();
        $sources = LeadSource::where('status', 'active')->orderBy('name')->get();

        if ($currentUser->isEmployee()) {
            $assigned = $currentUser->categoryTargets()->where('status', 'active')->orderBy('name')->get();
            if ($assigned->isNotEmpty()) {
                $categories = $assigned;
            } elseif ($currentUser->category_target_id) {
                $categories = CategoryTarget::where('id', $currentUser->category_target_id)->get();
            } else {
                $categories = CategoryTarget::where('status', 'active')->orderBy('name')->get();
            }
        } else {
            $categories = CategoryTarget::where('status', 'active')->orderBy('name')->get();
        }

        return view('leads.create', compact('sources', 'categories'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        if ($currentUser->isEmployee()) {
            $assignedIds = $currentUser->categoryTargets()->pluck('category_targets.id')->toArray();
            if (empty($assignedIds) && $currentUser->category_target_id) {
                $assignedIds = [$currentUser->category_target_id];
            }

            if (count($assignedIds) === 1 && !$request->filled('category_target_id')) {
                $request->merge(['category_target_id' => $assignedIds[0]]);
            }
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'lead_source_id' => ['required', 'exists:lead_sources,id'],
            'category_target_id' => [
                'required',
                'exists:category_targets,id',
                function ($attribute, $value, $fail) use ($currentUser) {
                    if ($currentUser->isEmployee()) {
                        $assignedIds = $currentUser->categoryTargets()->pluck('category_targets.id')->toArray();
                        if (empty($assignedIds) && $currentUser->category_target_id) {
                            $assignedIds = [$currentUser->category_target_id];
                        }
                        if (!empty($assignedIds) && !in_array($value, $assignedIds)) {
                            $fail('The selected target category is not assigned to your profile.');
                        }
                    }
                }
            ],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'new';

        $lead = Lead::create($validated);

        return redirect()->route('leads.show', $lead)
            ->with('success', 'Lead for "' . $lead->name . '" created successfully!');
    }

    public function show(Lead $lead)
    {
        $this->authorizeLeadAccess($lead);

        $lead->load(['user', 'leadSource', 'categoryTarget', 'followups.user']);

        return view('leads.show', compact('lead'));
    }

    public function storeFollowup(Request $request, Lead $lead)
    {
        $this->authorizeLeadAccess($lead);

        $validated = $request->validate([
            'followup_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['new', 'contacted', 'in_progress', 'won', 'lost'])],
            'remarks' => ['required', 'string'],
        ]);

        LeadFollowup::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'followup_date' => $validated['followup_date'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks'],
        ]);

        // Auto update lead status to match followup status
        $lead->status = $validated['status'];
        $lead->save();

        return redirect()->route('leads.show', $lead)
            ->with('success', 'Follow-up recorded successfully! Lead status updated to ' . strtoupper(str_replace('_', ' ', $validated['status'])) . '.');
    }

    public function edit(Lead $lead)
    {
        $this->authorizeLeadAccess($lead);
        $currentUser = Auth::user();

        $sources = LeadSource::where('status', 'active')->orderBy('name')->get();

        if ($currentUser->isEmployee()) {
            $assigned = $currentUser->categoryTargets()->where('status', 'active')->orderBy('name')->get();
            if ($assigned->isNotEmpty()) {
                $categories = $assigned;
            } elseif ($currentUser->category_target_id) {
                $categories = CategoryTarget::where('id', $currentUser->category_target_id)->get();
            } else {
                $categories = CategoryTarget::where('status', 'active')->orderBy('name')->get();
            }
        } else {
            $categories = CategoryTarget::where('status', 'active')->orderBy('name')->get();
        }

        return view('leads.edit', compact('lead', 'sources', 'categories'));
    }

    public function update(Request $request, Lead $lead)
    {
        $this->authorizeLeadAccess($lead);
        $currentUser = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'lead_source_id' => ['required', 'exists:lead_sources,id'],
            'category_target_id' => [
                'required',
                'exists:category_targets,id',
                function ($attribute, $value, $fail) use ($currentUser) {
                    if ($currentUser->isEmployee()) {
                        $assignedIds = $currentUser->categoryTargets()->pluck('category_targets.id')->toArray();
                        if (empty($assignedIds) && $currentUser->category_target_id) {
                            $assignedIds = [$currentUser->category_target_id];
                        }
                        if (!empty($assignedIds) && !in_array($value, $assignedIds)) {
                            $fail('The selected target category is not assigned to your profile.');
                        }
                    }
                }
            ],
            'status' => ['required', Rule::in(['new', 'contacted', 'in_progress', 'won', 'lost'])],
            'notes' => ['nullable', 'string'],
        ]);

        $lead->update($validated);

        return redirect()->route('leads.show', $lead)
            ->with('success', 'Lead details updated successfully!');
    }

    public function destroy(Lead $lead)
    {
        $this->authorizeLeadAccess($lead);

        $name = $lead->name;
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead "' . $name . '" deleted successfully.');
    }

    private function authorizeLeadAccess(Lead $lead)
    {
        if (!Auth::user()->isAdmin() && $lead->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access. You can only view and manage your own leads.');
        }
    }
}
