@extends('layouts.app')

@section('title', 'Edit Lead Source')
@section('page-title', 'Edit Lead Source')

@section('content')
<style>
    .form-card {
        background: #FFFFFF;
        border-radius: var(--r-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        max-width: 780px;
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
        min-height: 100px;
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
            <span>Edit Lead Source: {{ $leadSource->name }}</span>
        </h2>
        <a href="{{ route('lead-sources.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Sources</span>
        </a>
    </div>

    <form action="{{ route('lead-sources.update', $leadSource) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-body">
            <div class="form-group">
                <label class="form-label" for="name">Source Name <span style="color: var(--danger);">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $leadSource->name) }}" required>
                @error('name')
                    <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="icon">FontAwesome Icon Class</label>
                    <input type="text" id="icon" name="icon" class="form-input" value="{{ old('icon', $leadSource->icon) }}">
                    @error('icon')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color: var(--danger);">*</span></label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="active" {{ old('status', $leadSource->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $leadSource->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="description">Description / Notes</label>
                <textarea id="description" name="description" class="form-textarea">{{ old('description', $leadSource->description) }}</textarea>
                @error('description')
                    <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('lead-sources.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-xmark"></i>
                <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Update Source</span>
            </button>
        </div>
    </form>
</div>
@endsection
