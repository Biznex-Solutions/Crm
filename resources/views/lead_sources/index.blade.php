@extends('layouts.app')

@section('title', 'Lead Sources')
@section('page-title', 'Lead Sources')

@section('content')
<style>
    /* Filter Bar Card */
    .filter-card {
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        padding: 20px 24px;
        margin-bottom: 28px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 260px;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 15px;
    }

    .filter-input {
        width: 100%;
        padding: 11px 16px 11px 44px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        color: var(--text-primary);
        background: #F8FAFC;
        outline: none;
        transition: all 0.2s;
    }

    .filter-input:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .filter-select {
        padding: 11px 16px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        color: var(--text-primary);
        background: #F8FAFC;
        outline: none;
        cursor: pointer;
        min-width: 150px;
        transition: all 0.2s;
    }

    .filter-select:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
    }

    /* Table Container */
    .table-card {
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .table-header-bar {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .table-header-bar h2 {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-container {
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #F8FAFC;
        padding: 14px 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
    }

    .custom-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: var(--text-primary);
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }

    .custom-table tr:hover td {
        background: #F8FAFC;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-active {
        background: #DEF7EC;
        color: #03543F;
    }
    .badge-active .badge-dot { background: #31C48D; }

    .badge-inactive {
        background: #FDE8E8;
        color: #9B1C1C;
    }
    .badge-inactive .badge-dot { background: #F05252; }

    /* Action Buttons */
    .action-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: #FFFFFF;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-action.edit:hover {
        background: #E0F2FE;
        color: #0284C7;
        border-color: #38BDF8;
    }

    .btn-action.toggle:hover {
        background: #FEF3C7;
        color: #D97706;
        border-color: #FBBF24;
    }

    .btn-action.delete:hover {
        background: #FEE2E2;
        color: #DC2626;
        border-color: #FCA5A5;
    }

    .pagination-wrapper {
        padding: 20px 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .source-icon-badge {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        box-shadow: 0 3px 10px rgba(0,0,0,0.04);
    }
</style>

<!-- Filter Controls Bar -->
<div class="filter-card">
    <form action="{{ route('lead-sources.index') }}" method="GET" class="filter-form">
        <div class="search-input-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" class="filter-input" placeholder="Search lead sources (e.g. WhatsApp, Call, Facebook)..." value="{{ request('search') }}">
        </div>

        <div>
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
            </select>
        </div>

        <button type="submit" class="btn-primary" style="padding: 10px 18px;">
            <i class="fa-solid fa-filter"></i>
            <span>Filter</span>
        </button>

        @if(request('search') || request('status'))
            <a href="{{ route('lead-sources.index') }}" class="btn-secondary" style="padding: 10px 16px;">
                <i class="fa-solid fa-xmark"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-header-bar">
        <h2>
            <i class="fa-solid fa-bullhorn" style="color: var(--primary-indigo);"></i>
            <span>Lead Sources Directory</span>
            <span style="font-size: 13px; font-weight: 600; color: var(--text-muted); background: #F1F5F9; padding: 4px 10px; border-radius: 20px;">
                {{ $leadSources->total() }} Total
            </span>
        </h2>

        <a href="{{ route('lead-sources.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Add New Source</span>
        </a>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Source Channel</th>
                    <th>Description</th>
                    <th>Icon Class</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leadSources as $source)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @php
                                    $bgStyle = 'background: #F1F5F9; color: #475569;';
                                    if (str_contains($source->icon, 'whatsapp')) $bgStyle = 'background: #DCFCE7; color: #15803D;';
                                    elseif (str_contains($source->icon, 'facebook')) $bgStyle = 'background: #DBEAFE; color: #1D4ED8;';
                                    elseif (str_contains($source->icon, 'instagram')) $bgStyle = 'background: #FCE7F3; color: #BE185D;';
                                    elseif (str_contains($source->icon, 'phone')) $bgStyle = 'background: #FEF3C7; color: #B45309;';
                                    elseif (str_contains($source->icon, 'google')) $bgStyle = 'background: #FEE2E2; color: #B91C1C;';
                                    elseif (str_contains($source->icon, 'linkedin')) $bgStyle = 'background: #E0F2FE; color: #0369A1;';
                                @endphp
                                <div class="source-icon-badge" style="{{ $bgStyle }}">
                                    <i class="{{ $source->icon ?? 'fa-solid fa-bullhorn' }}"></i>
                                </div>
                                <div style="font-weight: 700; color: var(--text-primary);">
                                    {{ $source->name }}
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--text-secondary); max-width: 320px;">
                            {{ Str::limit($source->description, 75) ?? '—' }}
                        </td>
                        <td>
                            <code style="background: #F1F5F9; color: #475569; padding: 4px 8px; border-radius: 6px; font-size: 12px;">
                                {{ $source->icon ?? 'fa-solid fa-bullhorn' }}
                            </code>
                        </td>
                        <td>
                            <span class="badge badge-{{ $source->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($source->status) }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 13px;">
                            {{ $source->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="action-group" style="justify-content: flex-end;">
                                <!-- Toggle Status -->
                                <form action="{{ route('lead-sources.toggle-status', $source) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-action toggle" title="Toggle Active/Inactive Status">
                                        <i class="fa-solid fa-power-off"></i>
                                    </button>
                                </form>

                                <!-- Edit -->
                                <a href="{{ route('lead-sources.edit', $source) }}" class="btn-action edit" title="Edit Lead Source">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('lead-sources.destroy', $source) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete source {{ $source->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Delete Lead Source">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fa-solid fa-bullhorn" style="font-size: 32px; color: #CBD5E1; margin-bottom: 12px; display: block;"></i>
                            No lead sources found matching your criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leadSources->hasPages())
        <div class="pagination-wrapper">
            {{ $leadSources->links() }}
        </div>
    @endif
</div>
@endsection
