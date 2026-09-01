@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Command Center')

@section('content')
<style>
    /* Hero CTA Banner */
    .dash-banner {
        background: var(--grad-brand);
        border-radius: var(--r-xl);
        padding: 30px 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
        box-shadow: 0 10px 40px rgba(61, 90, 254, 0.28);
        position: relative;
        overflow: hidden;
    }

    .dash-banner::before {
        content: '';
        position: absolute;
        right: -60px; top: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }

    .dash-banner::after {
        content: '';
        position: absolute;
        right: 120px; bottom: -80px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }

    .banner-text { position: relative; z-index: 2; }
    .banner-text h2 {
        font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.3px;
        margin-bottom: 6px;
    }

    .banner-text p {
        font-size: 14px;
        color: rgba(255,255,255,0.75);
    }

    .banner-actions {
        display: flex;
        gap: 12px;
        position: relative;
        z-index: 2;
    }

    .banner-btn-white {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: var(--accent);
        font-size: 13.5px;
        font-weight: 700;
        padding: 11px 20px;
        border-radius: var(--r-md);
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        transition: all 0.18s;
    }

    .banner-btn-white:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.18); }

    .banner-btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.15);
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        padding: 11px 20px;
        border-radius: var(--r-md);
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.25);
        transition: all 0.18s;
    }

    .banner-btn-ghost:hover { background: rgba(255,255,255,0.22); }

    /* User performance lead count badge */
    .lead-badge {
        font-size: 13px;
        font-weight: 800;
        color: var(--accent);
        background: var(--accent-soft);
        padding: 4px 12px;
        border-radius: 12px;
        border: 1px solid #C7D2FE;
    }

    /* Progress bar for won deals */
    .mini-bar-wrap {
        height: 4px;
        background: var(--border);
        border-radius: 10px;
        margin-top: 8px;
        overflow: hidden;
    }

    .mini-bar-fill {
        height: 100%;
        background: var(--grad-green);
        border-radius: 10px;
        transition: width 0.8s ease;
    }

    @media (max-width: 900px) {
        .dash-banner { padding: 22px 24px; }
        .dash-banner .banner-text h2 { font-size: 20px; }
        .banner-actions { width: 100%; }
        .banner-btn-white, .banner-btn-ghost { flex: 1; justify-content: center; font-size: 13px; padding: 10px 14px; }
    }

    @media (max-width: 550px) {
        .dash-banner { padding: 18px; border-radius: 18px; }
        .dash-banner .banner-text h2 { font-size: 17px; }
        .dash-banner .banner-text p { font-size: 13px; }
    }
</style>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card c-blue">
        <div class="stat-ic c-blue"><i class="fa-solid fa-address-book"></i></div>
        <div class="stat-data">
            <h3>{{ $stats['total_leads'] }}</h3>
            <p>{{ Auth::user()->isAdmin() ? 'Total Leads Captured' : 'My Total Leads' }}</p>
        </div>
    </div>

    <div class="stat-card c-green">
        <div class="stat-ic c-green"><i class="fa-solid fa-trophy"></i></div>
        <div class="stat-data">
            <h3>{{ $stats['won_deals'] }}</h3>
            <p>Deals Won 🎉</p>
        </div>
    </div>

    <div class="stat-card c-sky">
        <div class="stat-ic c-sky"><i class="fa-solid fa-bolt"></i></div>
        <div class="stat-data">
            <h3>{{ $stats['new_leads'] }}</h3>
            <p>New Inbound Leads</p>
        </div>
    </div>

    <div class="stat-card c-purple">
        <div class="stat-ic c-purple"><i class="fa-solid fa-rotate"></i></div>
        <div class="stat-data">
            <h3>{{ $stats['in_progress_leads'] }}</h3>
            <p>In Active Pipeline</p>
        </div>
    </div>

    @if(Auth::user()->isAdmin() && isset($stats['total_users']))
        <div class="stat-card c-orange">
            <div class="stat-ic c-orange"><i class="fa-solid fa-users"></i></div>
            <div class="stat-data">
                <h3>{{ $stats['active_users'] }}</h3>
                <p>Active Team Members</p>
            </div>
        </div>
    @endif
</div>

<!-- Hero Banner -->
<div class="dash-banner">
    <div class="banner-text">
        <h2>
            @if(Auth::user()->isAdmin())
                Team Lead & Sales Overview
            @else
                Your Personal Lead Pipeline
            @endif
        </h2>
        <p>
            @if(Auth::user()->isAdmin())
                Full visibility into team performance, categories, and follow-up activity across all employees.
            @else
                Track your assigned leads, log follow-ups, and close more deals today.
            @endif
        </p>
    </div>

    <div class="banner-actions">
        <a href="{{ route('leads.create') }}" class="banner-btn-white">
            <i class="fa-solid fa-plus"></i>
            <span>New Lead</span>
        </a>
        <a href="{{ route('leads.index') }}" class="banner-btn-ghost">
            <i class="fa-solid fa-list"></i>
            <span>View All Leads</span>
        </a>
    </div>
</div>

@if($userLeadStats)
<!-- Team Performance Table (Admin Only) -->
<div class="card" style="margin-bottom: 28px;">
    <div class="card-header">
        <div class="card-title">
            <div class="card-title-icon" style="background: var(--accent-soft); color: var(--accent);">
                <i class="fa-solid fa-chart-user"></i>
            </div>
            <span>Team Lead Performance</span>
            <span style="font-size: 12px; font-weight: 600; color: var(--text-300); background: var(--bg-base); padding: 3px 10px; border-radius: 20px; border: 1px solid var(--border);">
                {{ $userLeadStats->count() }} Members
            </span>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            <span>Team Directory</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Team Member</th>
                    <th>Role</th>
                    <th>Total Leads</th>
                    <th>New</th>
                    <th>Contacted</th>
                    <th>In Progress</th>
                    <th>Won</th>
                    <th>Lost</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userLeadStats as $u)
                    @php
                        $wonPct = $u->leads_count > 0 ? round(($u->won_count / $u->leads_count) * 100) : 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex ai-center gap-8">
                                <div class="avatar" style="background: var(--grad-brand);">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-bold" style="font-size: 13.5px; color: var(--text-100);">{{ $u->name }}</div>
                                    <div class="text-sm text-muted">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="pill badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span>
                        </td>
                        <td>
                            <span class="lead-badge">{{ $u->leads_count }} Leads</span>
                        </td>
                        <td><span class="pill pill-new">{{ $u->new_count }}</span></td>
                        <td><span class="pill pill-contacted">{{ $u->contacted_count }}</span></td>
                        <td><span class="pill pill-in_progress">{{ $u->in_progress_count }}</span></td>
                        <td>
                            <div>
                                <span class="pill pill-won">{{ $u->won_count }}</span>
                                <div class="mini-bar-wrap" style="width: 60px;">
                                    <div class="mini-bar-fill" style="width: {{ $wonPct }}%;"></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="pill pill-lost">{{ $u->lost_count }}</span></td>
                        <td>
                            <div class="action-group jc-end">
                                <a href="{{ route('leads.index', ['user_id' => $u->id]) }}" class="icon-btn view" title="View Leads">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('reports.export-csv', ['user_id' => $u->id]) }}" class="icon-btn report" title="Export CSV Report">
                                    <i class="fa-solid fa-file-csv"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: var(--text-400);">
                            No team members yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Recent Leads -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-title-icon" style="background: var(--info-soft); color: var(--info);">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <span>Recent Lead Activity</span>
        </div>
        <a href="{{ route('leads.index') }}" class="btn btn-secondary btn-sm">
            <span>View All</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Source</th>
                    <th>Category</th>
                    <th>Owner</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLeads as $lead)
                    <tr>
                        <td>
                            <div class="text-bold" style="color: var(--text-100);">{{ $lead->name }}</div>
                            @if($lead->email)
                                <div class="text-sm text-muted">{{ $lead->email }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="text-sm" style="font-weight: 600;">{{ $lead->phone }}</div>
                            @if($lead->whatsapp)
                                <div class="text-xs" style="color: #10B981;"><i class="fa-brands fa-whatsapp"></i> {{ $lead->whatsapp }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 12.5px; font-weight: 700; color: var(--accent);">
                                <i class="{{ $lead->leadSource->icon ?? 'fa-solid fa-bullhorn' }}" style="margin-right: 4px;"></i>
                                {{ $lead->leadSource->name ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 12.5px; font-weight: 700; color: var(--accent-2);">
                                {{ $lead->categoryTarget->name ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex ai-center gap-8">
                                <div class="avatar" style="width:28px;height:28px;font-size:11px;border-radius:8px;">
                                    {{ strtoupper(substr($lead->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-sm">{{ $lead->user->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="pill pill-{{ $lead->status }}">
                                {{ str_replace('_', ' ', $lead->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-400);">
                            No recent leads recorded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
