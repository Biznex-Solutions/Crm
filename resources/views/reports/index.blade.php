@extends('layouts.app')

@section('title', 'Employee Lead Reports')
@section('page-title', 'Employee Lead Reports & Excel/CSV Export')

@section('content')
<style>
    .report-card {
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .report-form {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
    }

    .form-group-item {
        flex: 1;
        min-width: 220px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        color: var(--text-primary);
        background: #F8FAFC;
        outline: none;
    }

    .form-select:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    /* Stats Pills Grid */
    .report-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-pill-card {
        background: #FFFFFF;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.02);
    }

    .stat-pill-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .stat-pill-info h3 {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.2;
    }

    .stat-pill-info p {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
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
        padding: 14px 18px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
    }

    .custom-table td {
        padding: 16px 18px;
        font-size: 14px;
        color: var(--text-primary);
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }

    .custom-table tr:hover td {
        background: #F8FAFC;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-new { background: #E0F2FE; color: #0369A1; }
    .status-contacted { background: #FEF3C7; color: #B45309; }
    .status-in_progress { background: #EDE9FE; color: #6D28D9; }
    .status-won { background: #DCFCE7; color: #15803D; }
    .status-lost { background: #FEE2E2; color: #B91C1C; }
</style>

<!-- Top Banner & Export Card -->
<div class="report-card">
    <div style="margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-file-excel" style="color: #16A34A;"></i>
            <span>Generate & Download Employee Lead Reports</span>
        </h2>
        <p style="font-size: 14px; color: var(--text-muted); margin-top: 4px;">
            Select an employee below to view their leads and generate a complete Excel/CSV report file.
        </p>
    </div>

    <form action="{{ route('reports.index') }}" method="GET" class="report-form">
        <div class="form-group-item">
            <label class="form-label" for="user_id">Select Employee</label>
            <select id="user_id" name="user_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Employees (System Wide)</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                        {{ $u->name }} ({{ ucfirst($u->role) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group-item">
            <label class="form-label" for="status">Lead Status Filter</label>
            <select id="status" name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="won" {{ request('status') == 'won' ? 'selected' : '' }}>Won Deals</option>
                <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost Deals</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('reports.export-csv', request()->query()) }}" class="btn-primary" style="background: #16A34A; box-shadow: 0 4px 14px rgba(22, 163, 74, 0.25); padding: 12px 22px;">
                <i class="fa-solid fa-file-excel" style="font-size: 16px;"></i>
                <span>Download Excel / CSV Report</span>
            </a>

            @if(request('user_id') || request('status'))
                <a href="{{ route('reports.index') }}" class="btn-secondary" style="padding: 12px 18px;">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Reset</span>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Employee Stats Overview -->
<div class="report-stats-grid">
    <div class="stat-pill-card">
        <div class="stat-pill-icon" style="background: #EEF2FF; color: #4F46E5;">
            <i class="fa-solid fa-folder-open"></i>
        </div>
        <div class="stat-pill-info">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total Lead Files</p>
        </div>
    </div>

    <div class="stat-pill-card">
        <div class="stat-pill-icon" style="background: #DCFCE7; color: #16A34A;">
            <i class="fa-solid fa-trophy"></i>
        </div>
        <div class="stat-pill-info">
            <h3>{{ $stats['won'] }}</h3>
            <p>Won Deals 🎉</p>
        </div>
    </div>

    <div class="stat-pill-card">
        <div class="stat-pill-icon" style="background: #E0F2FE; color: #0284C7;">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div class="stat-pill-info">
            <h3>{{ $stats['new'] }}</h3>
            <p>New Leads</p>
        </div>
    </div>

    <div class="stat-pill-card">
        <div class="stat-pill-icon" style="background: #EDE9FE; color: #7C3AED;">
            <i class="fa-solid fa-spinner"></i>
        </div>
        <div class="stat-pill-info">
            <h3>{{ $stats['in_progress'] }}</h3>
            <p>In Progress</p>
        </div>
    </div>

    <div class="stat-pill-card">
        <div class="stat-pill-icon" style="background: #FEF3C7; color: #D97706;">
            <i class="fa-solid fa-comments"></i>
        </div>
        <div class="stat-pill-info">
            <h3>{{ $stats['contacted'] }}</h3>
            <p>Contacted</p>
        </div>
    </div>

    <div class="stat-pill-card">
        <div class="stat-pill-icon" style="background: #FEE2E2; color: #DC2626;">
            <i class="fa-solid fa-circle-xmark"></i>
        </div>
        <div class="stat-pill-info">
            <h3>{{ $stats['lost'] }}</h3>
            <p>Lost Deals</p>
        </div>
    </div>
</div>

<!-- Employee Leads Preview Table -->
<div class="table-card">
    <div class="table-header-bar">
        <h2>
            <i class="fa-solid fa-users" style="color: var(--primary-indigo);"></i>
            <span>
                @if($selectedEmployee)
                    Report Preview for {{ $selectedEmployee->name }}
                @else
                    All Employee Lead Files
                @endif
            </span>
            <span style="font-size: 13px; font-weight: 600; color: var(--text-muted); background: #F1F5F9; padding: 4px 10px; border-radius: 20px;">
                {{ $leads->total() }} Records
            </span>
        </h2>

        <a href="{{ route('reports.export-csv', request()->query()) }}" class="btn-primary" style="background: #16A34A; padding: 9px 18px; font-size: 13px;">
            <i class="fa-solid fa-download"></i>
            <span>Export CSV</span>
        </a>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Lead ID</th>
                    <th>Assigned Employee</th>
                    <th>Customer Name</th>
                    <th>Phone / WhatsApp</th>
                    <th>Lead Source</th>
                    <th>Target Category</th>
                    <th>Status</th>
                    <th>Follow-ups</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td style="font-weight: 800; color: var(--text-muted);">
                            #{{ $lead->id }}
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-primary);">{{ $lead->user->name ?? 'Unassigned' }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ $lead->user->email ?? '' }}</div>
                        </td>
                        <td style="font-weight: 700; color: var(--text-primary);">
                            {{ $lead->name }}
                        </td>
                        <td>
                            <div style="font-weight: 600; font-size: 13px;">{{ $lead->phone }}</div>
                            @if($lead->whatsapp)
                                <div style="font-size: 12px; color: #16A34A;"><i class="fa-brands fa-whatsapp"></i> {{ $lead->whatsapp }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 12px; font-weight: 700; color: #4F46E5;">
                                {{ $lead->leadSource->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 12px; font-weight: 700; color: #7C3AED;">
                                {{ $lead->categoryTarget->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status status-{{ $lead->status }}">
                                {{ str_replace('_', ' ', $lead->status) }}
                            </span>
                        </td>
                        <td style="font-weight: 700; text-align: center;">
                            {{ $lead->followups->count() }}
                        </td>
                        <td style="font-size: 13px; color: var(--text-muted);">
                            {{ $lead->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            No lead records found for the selected criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
        <div style="padding: 20px 24px; border-top: 1px solid var(--border-color);">
            {{ $leads->links() }}
        </div>
    @endif
</div>
@endsection
