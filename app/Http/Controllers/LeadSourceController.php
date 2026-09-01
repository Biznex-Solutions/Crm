<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LeadSourceController extends Controller
{
    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $search = $request->query('search');
        $status = $request->query('status');

        $leadSources = LeadSource::query()
            ->search($search)
            ->filterStatus($status)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => LeadSource::count(),
            'active' => LeadSource::where('status', 'active')->count(),
            'inactive' => LeadSource::where('status', 'inactive')->count(),
        ];

        return view('lead_sources.index', compact('leadSources', 'search', 'status', 'stats'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('lead_sources.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:lead_sources,name'],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        if (empty($validated['icon'])) {
            $validated['icon'] = 'fa-solid fa-bullhorn';
        }

        LeadSource::create($validated);

        return redirect()->route('lead-sources.index')
            ->with('success', 'Lead Source "' . $validated['name'] . '" created successfully!');
    }

    public function edit(LeadSource $leadSource)
    {
        $this->authorizeAdmin();

        return view('lead_sources.edit', compact('leadSource'));
    }

    public function update(Request $request, LeadSource $leadSource)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('lead_sources')->ignore($leadSource->id)],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        if (empty($validated['icon'])) {
            $validated['icon'] = 'fa-solid fa-bullhorn';
        }

        $leadSource->update($validated);

        return redirect()->route('lead-sources.index')
            ->with('success', 'Lead Source "' . $leadSource->name . '" updated successfully!');
    }

    public function destroy(LeadSource $leadSource)
    {
        $this->authorizeAdmin();

        $name = $leadSource->name;
        $leadSource->delete();

        return redirect()->route('lead-sources.index')
            ->with('success', 'Lead Source "' . $name . '" deleted successfully.');
    }

    public function toggleStatus(LeadSource $leadSource)
    {
        $this->authorizeAdmin();

        $leadSource->status = ($leadSource->status === 'active') ? 'inactive' : 'active';
        $leadSource->save();

        return redirect()->route('lead-sources.index')
            ->with('success', 'Status for "' . $leadSource->name . '" changed to ' . ucfirst($leadSource->status) . '.');
    }
}
