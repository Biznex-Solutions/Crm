@extends('layouts.app')

@section('title', 'Leads Management')
@section('page-title', 'Leads Management')

@section('content')
<style>
    @media (max-width: 900px) {
        .section-hero .btn { width: 100%; justify-content: center; }
    }
    @media (max-width: 550px) {
        /* Quick stat mini row: 3 per row */
        .stats-row[style*="minmax(160px"] { grid-template-columns: repeat(3, 1fr) !important; gap: 8px !important; }
        .stat-card[style*="padding: 16px"] { padding: 12px !important; gap: 8px !important; }
    }
</style>

<!-- Section Hero -->
<div class="section-hero">
    <div class="hero-text">
        <h2>Lead Pipeline</h2>
        <p>
            @if(Auth::user()->isAdmin())
                All system leads — filter by team member, source, category, or status.
            @else
                Your personally assigned leads — track, follow up, and close deals.
            @endif
        </p>
    </div>
    <a href="{{ route('leads.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-circle-plus"></i>
        <span>Add New Lead</span>
    </a>
</div>

<!-- Quick Stats Row -->
<div class="stats-row" style="grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin-bottom: 22px;">
    <div class="stat-card c-blue" style="padding: 16px 20px;">
        <div class="stat-ic c-blue" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-address-book"></i></div>
        <div class="stat-data">
            <h3 style="font-size:22px;">{{ $stats['total'] }}</h3>
            <p>Total Leads</p>
        </div>
    </div>
    <div class="stat-card c-sky" style="padding: 16px 20px;">
        <div class="stat-ic c-sky" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-bolt"></i></div>
        <div class="stat-data">
            <h3 style="font-size:22px;">{{ $stats['new'] }}</h3>
            <p>New</p>
        </div>
    </div>
    <div class="stat-card c-orange" style="padding: 16px 20px;">
        <div class="stat-ic c-orange" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-comments"></i></div>
        <div class="stat-data">
            <h3 style="font-size:22px;">{{ $stats['contacted'] }}</h3>
            <p>Contacted</p>
        </div>
    </div>
    <div class="stat-card c-purple" style="padding: 16px 20px;">
        <div class="stat-ic c-purple" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-rotate"></i></div>
        <div class="stat-data">
            <h3 style="font-size:22px;">{{ $stats['in_progress'] }}</h3>
            <p>In Progress</p>
        </div>
    </div>
    <div class="stat-card c-green" style="padding: 16px 20px;">
        <div class="stat-ic c-green" style="width:42px;height:42px;font-size:17px;"><i class="fa-solid fa-trophy"></i></div>
        <div class="stat-data">
            <h3 style="font-size:22px;">{{ $stats['won'] }}</h3>
            <p>Won</p>
        </div>
    </div>
    <div class="stat-card" style="padding: 16px 20px; border-color: #FECACA;">
        <div class="stat-ic" style="width:42px;height:42px;font-size:17px;background:#FEE2E2;color:#DC2626;"><i class="fa-solid fa-ban"></i></div>
        <div class="stat-data">
            <h3 style="font-size:22px;">{{ $stats['lost'] }}</h3>
            <p>Lost</p>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form action="{{ route('leads.index') }}" method="GET">
        <div class="input-group" style="flex:1; min-width:220px;">
            <i class="input-icon fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" class="form-control has-icon f-input f-search" placeholder="Search name, email, phone..." value="{{ request('search') }}">
        </div>

        <select name="status" class="f-input" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>🔵 New</option>
            <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>🟡 Contacted</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>🟣 In Progress</option>
            <option value="won" {{ request('status') == 'won' ? 'selected' : '' }}>🟢 Won</option>
            <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>🔴 Lost</option>
        </select>

        <select name="lead_source_id" class="f-input" onchange="this.form.submit()">
            <option value="">All Sources</option>
            @foreach($sources as $src)
                <option value="{{ $src->id }}" {{ request('lead_source_id') == $src->id ? 'selected' : '' }}>{{ $src->name }}</option>
            @endforeach
        </select>

        <select name="category_target_id" class="f-input" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_target_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        @if(Auth::user()->isAdmin())
            <select name="user_id" class="f-input" onchange="this.form.submit()">
                <option value="">All Owners</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        @endif

        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-filter"></i>
            <span>Filter</span>
        </button>

        @if(request('search') || request('status') || request('lead_source_id') || request('category_target_id') || request('user_id'))
            <a href="{{ route('leads.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-xmark"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<!-- Leads Table -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-title-icon" style="background: var(--accent-soft); color: var(--accent);">
                <i class="fa-solid fa-address-book"></i>
            </div>
            <span>Lead Records</span>
            <span style="font-size: 12px; font-weight: 600; color: var(--text-300); background: var(--bg-base); padding: 3px 10px; border-radius: 20px; border: 1px solid var(--border);">
                {{ $leads->total() }} Total
            </span>
        </div>
    </div>

    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact Info</th>
                    <th>Lead Source</th>
                    <th>Target Category</th>
                    <th>Owner</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td>
                            <div class="text-bold" style="color: var(--text-100);">{{ $lead->name }}</div>
                            <div class="text-sm text-muted">{{ $lead->email ?? '—' }}</div>
                        </td>
                        <td>
                            <div class="text-sm" style="font-weight:600; display:flex; align-items:center; gap:5px;">
                                <i class="fa-solid fa-phone" style="color:var(--accent); font-size:10px;"></i>
                                {{ $lead->phone }}
                            </div>
                            @if($lead->whatsapp)
                                <div class="text-xs" style="color: var(--success); margin-top:2px;">
                                    <i class="fa-brands fa-whatsapp"></i> {{ $lead->whatsapp }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span style="display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; background:var(--accent-soft); color:var(--accent); padding:4px 10px; border-radius:8px;">
                                <i class="{{ $lead->leadSource->icon ?? 'fa-solid fa-bullhorn' }}"></i>
                                {{ $lead->leadSource->name ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size:12px; font-weight:700; color:var(--accent-2); background:var(--accent-2-soft); padding:4px 10px; border-radius:8px;">
                                {{ $lead->categoryTarget->name ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex ai-center gap-8">
                                <div class="avatar" style="width:28px;height:28px;font-size:11px;border-radius:8px;">
                                    {{ strtoupper(substr($lead->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-sm" style="font-weight:600;">{{ $lead->user->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="pill pill-{{ $lead->status }}">
                                {{ str_replace('_', ' ', $lead->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group jc-end">
                                <a href="{{ route('leads.show', $lead) }}" class="icon-btn view" title="View & Follow-up">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('leads.edit', $lead) }}" class="icon-btn edit" title="Edit Lead">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('leads.destroy', $lead) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete lead for {{ $lead->name }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="icon-btn delete" title="Delete Lead">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:50px; color:var(--text-400);">
                            <i class="fa-solid fa-address-book" style="font-size:36px; margin-bottom:12px; display:block; opacity:0.3;"></i>
                            No leads found. <a href="{{ route('leads.create') }}" style="color:var(--accent); font-weight:700;">Add your first lead →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
        <div style="padding: 18px 24px; border-top: 1px solid var(--border);">
            {{ $leads->links() }}
        </div>
    @endif
</div>
@endsection
