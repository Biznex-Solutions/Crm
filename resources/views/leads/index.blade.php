@extends('layouts.app')

@section('title', 'Leads Management')
@section('page-title', 'Leads Management')

@section('content')
<style>
    /* =========================================
       HERO & STATS RESPONSIVE
    ========================================= */
    .section-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .hero-text h2 {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-100);
        letter-spacing: -0.4px;
    }

    .hero-text p {
        font-size: 13.5px;
        color: var(--text-300);
        margin-top: 3px;
    }

    /* Stats Grid */
    .leads-stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 22px;
    }

    .lead-stat-chip {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .lead-stat-chip:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .stat-chip-ic {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .stat-chip-val {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-100);
        line-height: 1.1;
    }

    .stat-chip-lbl {
        font-size: 11.5px;
        color: var(--text-300);
        font-weight: 600;
        margin-top: 2px;
    }

    /* Colors */
    .chip-blue .stat-chip-ic { background: var(--accent-soft); color: var(--accent); }
    .chip-sky .stat-chip-ic { background: var(--info-soft); color: var(--info); }
    .chip-orange .stat-chip-ic { background: var(--warning-soft); color: var(--warning); }
    .chip-purple .stat-chip-ic { background: var(--accent-2-soft); color: var(--accent-2); }
    .chip-green .stat-chip-ic { background: var(--success-soft); color: var(--success); }
    .chip-red .stat-chip-ic { background: var(--danger-soft); color: var(--danger); }

    /* =========================================
       FILTER BAR RESPONSIVE
    ========================================= */
    .leads-filter-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 22px;
        box-shadow: var(--shadow-sm);
    }

    .leads-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box-wrap {
        position: relative;
        flex: 2;
        min-width: 240px;
    }

    .search-box-wrap .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-300);
        font-size: 14px;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 13.5px;
        color: var(--text-100);
        background: var(--bg-base);
        outline: none;
        transition: all 0.15s;
    }

    .search-input:focus {
        background: #fff;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .filter-select {
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        color: var(--text-200);
        background: var(--bg-base);
        outline: none;
        cursor: pointer;
        transition: all 0.15s;
        min-width: 140px;
        font-weight: 500;
    }

    .filter-select:focus {
        border-color: var(--accent);
        background: #fff;
    }

    .filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* =========================================
       DUAL VIEW: DESKTOP TABLE & MOBILE CARDS
    ========================================= */
    .leads-desktop-view {
        display: block;
    }

    .leads-mobile-view {
        display: none;
    }

    /* =========================================
       MOBILE LEAD CARD STYLES
    ========================================= */
    .lead-mobile-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .lead-mobile-card:active {
        border-color: var(--accent);
    }

    .lmc-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .lmc-user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .lmc-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--grad-brand);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 4px 12px var(--accent-glow);
    }

    .lmc-name-wrap {
        min-width: 0;
    }

    .lmc-name {
        font-size: 15px;
        font-weight: 800;
        color: var(--text-100);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
    }

    .lmc-sub {
        font-size: 12px;
        color: var(--text-300);
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    /* 1-Tap Quick Action Buttons on Mobile */
    .lmc-quick-contact {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .quick-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .quick-btn-call {
        background: var(--accent-soft);
        color: var(--accent);
        border: 1px solid rgba(61, 90, 254, 0.18);
    }

    .quick-btn-call:active {
        background: var(--accent);
        color: #fff;
    }

    .quick-btn-wa {
        background: #DCFCE7;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }

    .quick-btn-wa:active {
        background: #16A34A;
        color: #fff;
    }

    /* Tags / Meta row */
    .lmc-tags {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        padding-top: 4px;
        border-top: 1px solid var(--border);
    }

    .lmc-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 9px;
        border-radius: 6px;
    }

    .lmc-badge-src {
        background: var(--accent-soft);
        color: var(--accent);
    }

    .lmc-badge-cat {
        background: var(--accent-2-soft);
        color: var(--accent-2);
    }

    .lmc-badge-owner {
        background: var(--bg-base);
        color: var(--text-200);
        border: 1px solid var(--border);
    }

    /* Card Bottom Actions */
    .lmc-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-top: 8px;
        border-top: 1px dashed var(--border);
    }

    .btn-view-lead-mob {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: var(--grad-brand);
        color: #fff !important;
        font-size: 12.5px;
        font-weight: 700;
        padding: 9px 14px;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 3px 12px var(--accent-glow);
    }

    .mob-action-icon-btns {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* =========================================
       RESPONSIVE BREAKPOINTS (TABLET & MOBILE)
    ========================================= */
    @media (max-width: 1100px) {
        .leads-stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .leads-desktop-view {
            display: none !important;
        }

        .leads-mobile-view {
            display: flex !important;
            flex-direction: column;
        }

        .section-hero {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .section-hero .btn {
            width: 100%;
            justify-content: center;
        }

        .leads-stats-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }

        .lead-stat-chip {
            padding: 10px 12px;
            gap: 8px;
            border-radius: 12px;
        }

        .stat-chip-ic {
            width: 32px;
            height: 32px;
            font-size: 13px;
            border-radius: 8px;
        }

        .stat-chip-val {
            font-size: 17px;
        }

        .stat-chip-lbl {
            font-size: 10.5px;
        }

        .leads-filter-card {
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 16px;
        }

        .leads-filter-form {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }

        .search-box-wrap {
            min-width: unset;
            width: 100%;
        }

        .filter-select {
            width: 100%;
            min-width: unset;
        }

        .filter-actions {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 4px;
        }

        .filter-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .leads-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .lmc-quick-contact {
            grid-template-columns: 1fr;
        }
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
<div class="leads-stats-grid">
    <div class="lead-stat-chip chip-blue">
        <div class="stat-chip-ic"><i class="fa-solid fa-address-book"></i></div>
        <div>
            <div class="stat-chip-val">{{ $stats['total'] }}</div>
            <div class="stat-chip-lbl">Total</div>
        </div>
    </div>
    <div class="lead-stat-chip chip-sky">
        <div class="stat-chip-ic"><i class="fa-solid fa-bolt"></i></div>
        <div>
            <div class="stat-chip-val">{{ $stats['new'] }}</div>
            <div class="stat-chip-lbl">New</div>
        </div>
    </div>
    <div class="lead-stat-chip chip-orange">
        <div class="stat-chip-ic"><i class="fa-solid fa-comments"></i></div>
        <div>
            <div class="stat-chip-val">{{ $stats['contacted'] }}</div>
            <div class="stat-chip-lbl">Contacted</div>
        </div>
    </div>
    <div class="lead-stat-chip chip-purple">
        <div class="stat-chip-ic"><i class="fa-solid fa-rotate"></i></div>
        <div>
            <div class="stat-chip-val">{{ $stats['in_progress'] }}</div>
            <div class="stat-chip-lbl">In Progress</div>
        </div>
    </div>
    <div class="lead-stat-chip chip-green">
        <div class="stat-chip-ic"><i class="fa-solid fa-trophy"></i></div>
        <div>
            <div class="stat-chip-val">{{ $stats['won'] }}</div>
            <div class="stat-chip-lbl">Won</div>
        </div>
    </div>
    <div class="lead-stat-chip chip-red">
        <div class="stat-chip-ic"><i class="fa-solid fa-ban"></i></div>
        <div>
            <div class="stat-chip-val">{{ $stats['lost'] }}</div>
            <div class="stat-chip-lbl">Lost</div>
        </div>
    </div>
</div>

<!-- Responsive Filter Bar -->
<div class="leads-filter-card">
    <form action="{{ route('leads.index') }}" method="GET" class="leads-filter-form">
        <div class="search-box-wrap">
            <i class="search-icon fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" class="search-input" placeholder="Search name, phone, email..." value="{{ request('search') }}">
        </div>

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>🔵 New</option>
            <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>🟡 Contacted</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>🟣 In Progress</option>
            <option value="won" {{ request('status') == 'won' ? 'selected' : '' }}>🟢 Won</option>
            <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>🔴 Lost</option>
        </select>

        <select name="lead_source_id" class="filter-select" onchange="this.form.submit()">
            <option value="">All Sources</option>
            @foreach($sources as $src)
                <option value="{{ $src->id }}" {{ request('lead_source_id') == $src->id ? 'selected' : '' }}>{{ $src->name }}</option>
            @endforeach
        </select>

        <select name="category_target_id" class="filter-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_target_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        @if(Auth::user()->isAdmin())
            <select name="user_id" class="filter-select" onchange="this.form.submit()">
                <option value="">All Owners</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        @endif

        <div class="filter-actions">
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
        </div>
    </form>
</div>

<!-- =========================================
     1. DESKTOP VIEW: DATA TABLE (> 768px)
========================================= -->
<div class="leads-desktop-view">
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
                                    <a href="tel:{{ $lead->phone }}" style="color:inherit; text-decoration:none;">{{ $lead->phone }}</a>
                                </div>
                                @if($lead->whatsapp)
                                    <div class="text-xs" style="color: var(--success); margin-top:2px;">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->whatsapp) }}" target="_blank" style="color:inherit; text-decoration:none;">
                                            <i class="fa-brands fa-whatsapp"></i> {{ $lead->whatsapp }}
                                        </a>
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
</div>

<!-- =========================================
     2. MOBILE VIEW: RESPONSIVE CARDS (<= 768px)
========================================= -->
<div class="leads-mobile-view">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; padding: 0 4px;">
        <span style="font-size: 13px; font-weight: 700; color: var(--text-200);">
            <i class="fa-solid fa-address-book" style="color: var(--accent); margin-right: 5px;"></i>
            {{ $leads->total() }} Leads Found
        </span>
    </div>

    @forelse($leads as $lead)
        <div class="lead-mobile-card">
            <!-- Card Head -->
            <div class="lmc-head">
                <div class="lmc-user-info">
                    <div class="lmc-avatar">
                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                    </div>
                    <div class="lmc-name-wrap">
                        <div class="lmc-name">{{ $lead->name }}</div>
                        <div class="lmc-sub">
                            @if($lead->email)
                                <span><i class="fa-regular fa-envelope"></i> {{ $lead->email }}</span>
                            @else
                                <span><i class="fa-regular fa-clock"></i> {{ $lead->created_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <span class="pill pill-{{ $lead->status }}">
                    {{ str_replace('_', ' ', $lead->status) }}
                </span>
            </div>

            <!-- 1-Tap Quick Contact Bar -->
            <div class="lmc-quick-contact">
                <a href="tel:{{ $lead->phone }}" class="quick-btn quick-btn-call">
                    <i class="fa-solid fa-phone"></i>
                    <span>{{ $lead->phone }}</span>
                </a>

                @if($lead->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->whatsapp) }}" target="_blank" class="quick-btn quick-btn-wa">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                @elseif($lead->email)
                    <a href="mailto:{{ $lead->email }}" class="quick-btn quick-btn-call" style="background: var(--bg-base); color: var(--text-200); border-color: var(--border);">
                        <i class="fa-regular fa-envelope"></i>
                        <span>Email</span>
                    </a>
                @else
                    <a href="tel:{{ $lead->phone }}" class="quick-btn quick-btn-wa">
                        <i class="fa-solid fa-comment-sms"></i>
                        <span>SMS</span>
                    </a>
                @endif
            </div>

            <!-- Badges & Meta -->
            <div class="lmc-tags">
                <span class="lmc-badge lmc-badge-src">
                    <i class="{{ $lead->leadSource->icon ?? 'fa-solid fa-bullhorn' }}"></i>
                    {{ $lead->leadSource->name ?? 'Direct' }}
                </span>

                <span class="lmc-badge lmc-badge-cat">
                    <i class="fa-solid fa-layer-group"></i>
                    {{ $lead->categoryTarget->name ?? 'General' }}
                </span>

                <span class="lmc-badge lmc-badge-owner">
                    <i class="fa-solid fa-user-tie"></i>
                    {{ $lead->user->name ?? 'System' }}
                </span>
            </div>

            <!-- Bottom Actions -->
            <div class="lmc-foot">
                <a href="{{ route('leads.show', $lead) }}" class="btn-view-lead-mob">
                    <i class="fa-solid fa-eye"></i>
                    <span>View & Follow-up</span>
                </a>

                <div class="mob-action-icon-btns">
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
            </div>
        </div>
    @empty
        <div class="card" style="text-align: center; padding: 40px 20px; color: var(--text-400);">
            <i class="fa-solid fa-address-book" style="font-size: 36px; margin-bottom: 12px; display: block; opacity: 0.3;"></i>
            <p style="font-size: 14px; font-weight: 600; color: var(--text-200); margin-bottom: 6px;">No leads found</p>
            <p style="font-size: 12px; margin-bottom: 16px;">Try adjusting your filters or search query.</p>
            <a href="{{ route('leads.create') }}" class="btn btn-primary btn-sm" style="display: inline-flex;">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add New Lead</span>
            </a>
        </div>
    @endforelse

    @if($leads->hasPages())
        <div style="padding: 14px 4px; margin-top: 6px;">
            {{ $leads->links() }}
        </div>
    @endif
</div>

@endsection
