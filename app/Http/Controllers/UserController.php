<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CategoryTarget;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        $role = $request->query('role');
        $status = $request->query('status');

        $users = User::query()
            ->with('categoryTarget')
            ->search($search)
            ->filterRole($role)
            ->filterStatus($status)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'employees' => User::where('role', 'employee')->count(),
            'active' => User::where('status', 'active')->count(),
        ];

        return view('users.index', compact('users', 'search', 'role', 'status', 'stats'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $categories = CategoryTarget::where('status', 'active')->orderBy('name')->get();

        return view('users.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'employee'])],
            'category_target_id' => ['nullable', 'exists:category_targets,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'phone' => ['nullable', 'string', 'max:30'],
            'designation' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated['role'] === 'admin') {
            $validated['category_target_id'] = null;
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User "' . $validated['name'] . '" has been created successfully!');
    }

    public function edit(User $user)
    {
        $this->authorizeAdmin();

        $categories = CategoryTarget::where('status', 'active')->orderBy('name')->get();

        return view('users.edit', compact('user', 'categories'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'employee'])],
            'category_target_id' => ['nullable', 'exists:category_targets,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'phone' => ['nullable', 'string', 'max:30'],
            'designation' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated['role'] === 'admin') {
            $validated['category_target_id'] = null;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User details updated successfully!');
    }

    public function destroy(User $user)
    {
        $this->authorizeAdmin();

        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account while logged in!');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User "' . $userName . '" deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        $this->authorizeAdmin();

        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot deactivate your own logged-in account!');
        }

        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Status for "' . $user->name . '" changed to ' . ucfirst($user->status) . '.');
    }

    public function directLogin(Request $request, User $user)
    {
        $this->authorizeAdmin();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Direct login successful! You are now logged in as "' . $user->name . '".');
    }
}
