<?php

namespace App\Http\Controllers;

use App\Models\CategoryTarget;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CategoryTargetController extends Controller
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

        $categories = CategoryTarget::query()
            ->search($search)
            ->filterStatus($status)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => CategoryTarget::count(),
            'active' => CategoryTarget::where('status', 'active')->count(),
            'inactive' => CategoryTarget::where('status', 'inactive')->count(),
            'total_deals' => CategoryTarget::sum('target_deals'),
        ];

        return view('category_targets.index', compact('categories', 'search', 'status', 'stats'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('category_targets.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:category_targets,name'],
            'description' => ['nullable', 'string'],
            'target_deals' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        CategoryTarget::create($validated);

        return redirect()->route('category-targets.index')
            ->with('success', 'Category Target "' . $validated['name'] . '" created successfully!');
    }

    public function edit(CategoryTarget $categoryTarget)
    {
        $this->authorizeAdmin();

        return view('category_targets.edit', compact('categoryTarget'));
    }

    public function update(Request $request, CategoryTarget $categoryTarget)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('category_targets')->ignore($categoryTarget->id)],
            'description' => ['nullable', 'string'],
            'target_deals' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $categoryTarget->update($validated);

        return redirect()->route('category-targets.index')
            ->with('success', 'Category Target "' . $categoryTarget->name . '" updated successfully!');
    }

    public function destroy(CategoryTarget $categoryTarget)
    {
        $this->authorizeAdmin();

        $name = $categoryTarget->name;
        $categoryTarget->delete();

        return redirect()->route('category-targets.index')
            ->with('success', 'Category Target "' . $name . '" deleted successfully.');
    }

    public function toggleStatus(CategoryTarget $categoryTarget)
    {
        $this->authorizeAdmin();

        $categoryTarget->status = ($categoryTarget->status === 'active') ? 'inactive' : 'active';
        $categoryTarget->save();

        return redirect()->route('category-targets.index')
            ->with('success', 'Status for "' . $categoryTarget->name . '" changed to ' . ucfirst($categoryTarget->status) . '.');
    }
}
