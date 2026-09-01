@extends('layouts.app')

@section('title', 'Edit Lead')
@section('page-title', 'Edit Lead Profile')

@section('content')
<style>
    .form-card {
        background: #FFFFFF;
        border-radius: var(--r-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        max-width: 820px;
        margin: 0 auto;
        overflow: hidden;
    }

    .form-header {
        padding: 24px 32px;
        border-bottom: 1px solid var(--border);
        background: #FAFBFF;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-header h2 {
        font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
        font-size: 19px;
        font-weight: 800;
        color: var(--text-100);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-body {
        padding: 32px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-200);
        margin-bottom: 8px;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--border);
        border-radius: var(--r-md);
        font-size: 14px;
        color: var(--text-100);
        background: #FAFBFF;
        outline: none;
        transition: all 0.18s;
        font-family: inherit;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        background: #FFFFFF;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .form-textarea {
        resize: vertical;
        min-height: 110px;
    }

    .error-text {
        color: var(--danger);
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-footer {
        padding: 22px 32px;
        background: #FAFBFF;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 14px;
    }

    @media (max-width: 600px) {
        .form-grid-2 { grid-template-columns: 1fr !important; }
        .form-body { padding: 20px; }
        .form-header { padding: 18px 20px; }
        .form-footer { padding: 16px 20px; }
    }
</style>

<div class="form-card">
    <div class="form-header">
        <h2>
            <i class="fa-solid fa-pen-to-square" style="color: var(--accent);"></i>
            <span>Edit Lead: {{ $lead->name }}</span>
        </h2>
        <a href="{{ route('leads.show', $lead) }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Details</span>
        </a>
    </div>

    <form action="{{ route('leads.update', $lead) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-body">
            <!-- Name -->
            <div class="form-group">
                <label class="form-label" for="name">Customer Full Name <span style="color: var(--danger);">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $lead->name) }}" required>
                @error('name')
                    <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Phone & WhatsApp Grid -->
            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="phone">Phone Number <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $lead->phone) }}" required>
                    @error('phone')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="whatsapp">WhatsApp Number</label>
                    <input type="text" id="whatsapp" name="whatsapp" class="form-input" value="{{ old('whatsapp', $lead->whatsapp) }}">
                    @error('whatsapp')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email & Status Grid -->
            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $lead->email) }}">
                    @error('email')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Lead Status <span style="color: var(--danger);">*</span></label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="new" {{ old('status', $lead->status) == 'new' ? 'selected' : '' }}>New Prospect</option>
                        <option value="contacted" {{ old('status', $lead->status) == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="in_progress" {{ old('status', $lead->status) == 'in_progress' ? 'selected' : '' }}>In Progress / Negotiation</option>
                        <option value="won" {{ old('status', $lead->status) == 'won' ? 'selected' : '' }}>Won / Deal Closed</option>
                        <option value="lost" {{ old('status', $lead->status) == 'lost' ? 'selected' : '' }}>Lost / Dropped</option>
                    </select>
                    @error('status')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Lead Source & Target Category Grid -->
            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="lead_source_id">Lead Source <span style="color: var(--danger);">*</span></label>
                    <select id="lead_source_id" name="lead_source_id" class="form-select" required>
                        @foreach($sources as $source)
                            <option value="{{ $source->id }}" {{ old('lead_source_id', $lead->lead_source_id) == $source->id ? 'selected' : '' }}>
                                {{ $source->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lead_source_id')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="category_target_id">
                        Target Category <span style="color: var(--danger);">*</span>
                    </label>
                    <select id="category_target_id" name="category_target_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_target_id', $lead->category_target_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @if(Auth::user()->isEmployee() && (Auth::user()->categoryTargets()->exists() || Auth::user()->category_target_id))
                        <span style="font-size: 12px; color: var(--accent); margin-top: 5px; display: inline-flex; align-items: center; gap: 5px; font-weight: 600;">
                            <i class="fa-solid fa-lock"></i> Assigned to your employee profile ({{ count($categories) }} {{ count($categories) === 1 ? 'category' : 'categories' }} available)
                        </span>
                    @endif
                    @error('category_target_id')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="notes">Notes / Requirements</label>
                <textarea id="notes" name="notes" class="form-textarea">{{ old('notes', $lead->notes) }}</textarea>
                @error('notes')
                    <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('leads.show', $lead) }}" class="btn btn-secondary">
                <i class="fa-solid fa-xmark"></i>
                <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Update Lead Changes</span>
            </button>
        </div>
    </form>
</div>
@endsection
