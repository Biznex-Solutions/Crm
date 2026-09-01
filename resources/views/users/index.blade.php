@extends('layouts.app')

@section('title', 'Team Members')
@section('page-title', 'Team Management')

@section('content')
<style>
    @media (max-width: 900px) {
        .section-hero .btn { width: 100%; justify-content: center; }
    }
    @media (max-width: 550px) {
        .stats-row[style*="minmax(180px"] { grid-template-columns: repeat(2, 1fr) !important; gap: 8px !important; }
    }
</style>

<!-- Section Hero -->
<div class="section-hero">
    <div class="hero-text">
        <h2>Team Members</h2>
        <p>Manage your CRM users, roles, access levels, and generate employee performance reports.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-user-plus"></i>
        <span>Add Team Member</span>
    </a>
</div>

<!-- Quick Stats -->
<div class="stats-row" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 22px;">
    <div class="stat-card c-blue" style="padding: 16px 20px;">
        <div class="stat-ic c-blue" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-users"></i></div>
        <div class="stat-data"><h3 style="font-size:22px;">{{ $stats['total'] }}</h3><p>Total Users</p></div>
    </div>
    <div class="stat-card c-purple" style="padding: 16px 20px;">
        <div class="stat-ic c-purple" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="stat-data"><h3 style="font-size:22px;">{{ $stats['admins'] }}</h3><p>Admins</p></div>
    </div>
    <div class="stat-card c-sky" style="padding: 16px 20px;">
        <div class="stat-ic c-sky" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-user-tie"></i></div>
        <div class="stat-data"><h3 style="font-size:22px;">{{ $stats['employees'] }}</h3><p>Employees</p></div>
    </div>
    <div class="stat-card c-green" style="padding: 16px 20px;">
        <div class="stat-ic c-green" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-data"><h3 style="font-size:22px;">{{ $stats['active'] }}</h3><p>Active Members</p></div>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form action="{{ route('users.index') }}" method="GET">
        <div class="input-group" style="flex:1; min-width:220px;">
            <i class="input-icon fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" class="form-control has-icon f-input f-search" placeholder="Search by name, email, phone or designation..." value="{{ request('search') }}">
        </div>

        <select name="role" class="f-input" onchange="this.form.submit()">
            <option value="">All Roles</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin Only</option>
            <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee Only</option>
        </select>

        <select name="status" class="f-input" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-filter"></i>
            <span>Filter</span>
        </button>

        @if(request('search') || request('role') || request('status'))
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-xmark"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-title-icon" style="background: var(--accent-soft); color: var(--accent);">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <span>System Users</span>
            <span style="font-size:12px; font-weight:600; color:var(--text-300); background:var(--bg-base); padding:3px 10px; border-radius:20px; border:1px solid var(--border);">
                {{ $users->total() }} Total
            </span>
        </div>
    </div>

    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>User Profile</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Phone</th>
                    <th>Designation</th>
                    <th>Joined</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex ai-center gap-8">
                                <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="text-bold" style="font-size:13.5px; color:var(--text-100);">{{ $user->name }}</div>
                                    <div class="text-sm text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="pill badge-{{ $user->role }}">
                                <i class="fa-solid {{ $user->role === 'admin' ? 'fa-shield-halved' : 'fa-user' }}" style="font-size:10px;"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="pill {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                <i class="fa-solid fa-circle" style="font-size:7px;"></i>
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="text-sm" style="color:var(--text-300);">{{ $user->phone ?? '—' }}</td>
                        <td class="text-sm">
                            <div style="font-weight:600; color:var(--text-200);">{{ $user->designation ?? '—' }}</div>
                            @if($user->isEmployee() && $user->categoryTarget)
                                <div style="margin-top:4px;">
                                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:600; color:var(--accent); background:var(--accent-soft); padding:2px 8px; border-radius:12px; border:1px solid #C7D2FE;" title="Assigned Target Category">
                                        <i class="fa-solid fa-layer-group" style="font-size:9px;"></i>
                                        {{ $user->categoryTarget->name }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="text-sm text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-group jc-end">
                                <!-- CSV Report -->
                                <a href="{{ route('reports.export-csv', ['user_id' => $user->id]) }}" class="icon-btn report" title="Download CSV Report for {{ $user->name }}">
                                    <i class="fa-solid fa-file-csv"></i>
                                </a>

                                <!-- Direct Login -->
                                <form action="{{ route('users.direct-login', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="icon-btn login" title="Login as {{ $user->name }}">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </button>
                                </form>

                                <!-- Toggle Status -->
                                <form action="{{ route('users.toggle-status', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="icon-btn toggle" title="Toggle Status">
                                        <i class="fa-solid fa-power-off"></i>
                                    </button>
                                </form>

                                <!-- Edit -->
                                <a href="{{ route('users.edit', $user) }}" class="icon-btn edit" title="Edit User">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete {{ $user->name }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="icon-btn delete" title="Delete User">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:50px; color:var(--text-400);">
                            <i class="fa-solid fa-users-slash" style="font-size:36px; margin-bottom:12px; display:block; opacity:0.3;"></i>
                            No users match your search criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="padding:18px 24px; border-top:1px solid var(--border);">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
