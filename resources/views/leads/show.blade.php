@extends('layouts.app')

@section('title', 'Lead Details & Follow-ups')
@section('page-title', 'Lead Profile & Timeline')

@section('content')
<style>
    .lead-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
    }

    @media (max-width: 1024px) {
        .lead-grid {
            grid-template-columns: 1fr;
        }
    }

    .profile-card {
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        padding: 28px;
    }

    .avatar-large {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: var(--brand-gradient);
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 800;
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
        margin-bottom: 16px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 14px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: var(--text-muted);
        font-weight: 600;
    }

    .detail-value {
        color: var(--text-primary);
        font-weight: 700;
    }

    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-new { background: #E0F2FE; color: #0369A1; border: 1px solid #BAE6FD; }
    .status-contacted { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
    .status-in_progress { background: #EDE9FE; color: #6D28D9; border: 1px solid #DDD6FE; }
    .status-won { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
    .status-lost { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }

    /* Timeline Styling */
    .timeline-card {
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        padding: 28px;
    }

    .timeline {
        position: relative;
        padding-left: 28px;
        margin-top: 24px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: #E2E8F0;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -28px;
        top: 2px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 4px solid var(--primary-indigo);
    }

    .timeline-content {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 16px 20px;
    }

    .timeline-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .timeline-author {
        font-weight: 700;
        font-size: 14px;
        color: var(--text-primary);
    }

    .timeline-date {
        font-size: 12px;
        color: var(--text-muted);
    }

    .timeline-remarks {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* Form Card */
    .add-followup-box {
        background: #FAFAFC;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 28px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 14px;
        color: var(--text-primary);
        background: #FFFFFF;
        outline: none;
    }

    .form-textarea {
        resize: vertical;
        min-height: 80px;
    }
</style>

<div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
    <a href="{{ route('leads.index') }}" class="btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to Leads List</span>
    </a>

    <a href="{{ route('leads.edit', $lead) }}" class="btn-primary" style="padding: 10px 18px;">
        <i class="fa-solid fa-pen-to-square"></i>
        <span>Edit Lead Info</span>
    </a>
</div>

<div class="lead-grid">
    <!-- Left Column: Lead Profile Info -->
    <div>
        <div class="profile-card">
            <div class="avatar-large">
                {{ strtoupper(substr($lead->name, 0, 1)) }}
            </div>

            <h2 style="font-size: 20px; font-weight: 800; color: var(--text-primary);">{{ $lead->name }}</h2>
            <div style="margin-top: 6px; margin-bottom: 20px;">
                <span class="badge-status status-{{ $lead->status }}">
                    {{ str_replace('_', ' ', $lead->status) }}
                </span>
            </div>

            <div style="display: flex; gap: 10px; margin-bottom: 24px;">
                @if($lead->whatsapp)
                    @php
                        $cleanWA = preg_replace('/[^0-9]/', '', $lead->whatsapp);
                    @endphp
                    <a href="https://wa.me/{{ $cleanWA }}" target="_blank" class="btn-primary" style="flex: 1; justify-content: center; background: #16A34A; padding: 9px 12px; font-size: 13px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i>
                        <span>WhatsApp</span>
                    </a>
                @endif

                <a href="tel:{{ $lead->phone }}" class="btn-secondary" style="flex: 1; justify-content: center; padding: 9px 12px; font-size: 13px;">
                    <i class="fa-solid fa-phone" style="color: #2563EB;"></i>
                    <span>Call Phone</span>
                </a>
            </div>

            <div class="detail-row">
                <span class="detail-label">Phone</span>
                <span class="detail-value">{{ $lead->phone }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $lead->email ?? '—' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Lead Source</span>
                <span class="detail-value" style="color: #4F46E5;">
                    <i class="{{ $lead->leadSource->icon ?? 'fa-solid fa-bullhorn' }}" style="margin-right: 4px;"></i>
                    {{ $lead->leadSource->name ?? 'N/A' }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Target Category</span>
                <span class="detail-value" style="color: #7C3AED;">
                    {{ $lead->categoryTarget->name ?? 'N/A' }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Created By Owner</span>
                <span class="detail-value">{{ $lead->user->name ?? 'System' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Created On</span>
                <span class="detail-value">{{ $lead->created_at->format('M d, Y') }}</span>
            </div>

            @if($lead->notes)
                <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #F1F5F9;">
                    <span class="detail-label" style="display: block; margin-bottom: 6px;">Initial Notes</span>
                    <p style="font-size: 13px; color: var(--text-secondary); background: #F8FAFC; padding: 12px; border-radius: 10px; border: 1px solid #E2E8F0;">
                        {{ $lead->notes }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Log New Followup & Timeline -->
    <div>
        <div class="timeline-card">
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-clock-rotate-left" style="color: var(--primary-indigo);"></i>
                <span>Follow-Up Log & Lead Progress</span>
            </h3>

            <!-- Form to Add Follow-Up -->
            <div class="add-followup-box">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-plus-circle" style="color: #4F46E5;"></i>
                    <span>Log New Follow-Up Action</span>
                </h4>

                <form action="{{ route('leads.followup', $lead) }}" method="POST">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                        <div>
                            <label class="form-label" for="followup_date">Follow-Up Date <span style="color: #DC2626;">*</span></label>
                            <input type="date" id="followup_date" name="followup_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label class="form-label" for="status">Update Stage Status <span style="color: #DC2626;">*</span></label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="new" {{ $lead->status == 'new' ? 'selected' : '' }}>New</option>
                                <option value="contacted" {{ $lead->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="in_progress" {{ $lead->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="won" {{ $lead->status == 'won' ? 'selected' : '' }}>Deal Won 🎉</option>
                                <option value="lost" {{ $lead->status == 'lost' ? 'selected' : '' }}>Deal Lost ❌</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label class="form-label" for="remarks">Follow-Up Remarks / Conversation Notes <span style="color: #DC2626;">*</span></label>
                        <textarea id="remarks" name="remarks" class="form-textarea" placeholder="Detail client feedback, next call date, or key discussion points..." required></textarea>
                    </div>

                    <button type="submit" class="btn-primary" style="padding: 10px 20px;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Save Follow-Up Record</span>
                    </button>
                </form>
            </div>

            <!-- Historical Timeline List -->
            <h4 style="font-size: 14px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                Historical Activity Log ({{ $lead->followups->count() }})
            </h4>

            @if($lead->followups->isEmpty())
                <div style="text-align: center; padding: 32px; background: #F8FAFC; border-radius: 14px; color: var(--text-muted);">
                    <i class="fa-solid fa-comment-slash" style="font-size: 24px; color: #CBD5E1; margin-bottom: 8px; display: block;"></i>
                    No follow-ups recorded yet. Use the form above to log the first conversation!
                </div>
            @else
                <div class="timeline">
                    @foreach($lead->followups as $followup)
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <div>
                                        <span class="timeline-author">{{ $followup->user->name ?? 'User' }}</span>
                                        <span class="badge-status status-{{ $followup->status }}" style="margin-left: 8px; font-size: 10px; padding: 2px 8px;">
                                            {{ str_replace('_', ' ', $followup->status) }}
                                        </span>
                                    </div>
                                    <span class="timeline-date">
                                        <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i>
                                        {{ $followup->followup_date->format('M d, Y') }}
                                    </span>
                                </div>
                                <div class="timeline-remarks">
                                    {{ $followup->remarks }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
