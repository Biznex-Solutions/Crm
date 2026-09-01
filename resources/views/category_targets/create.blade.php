@extends('layouts.app')

@section('title', 'Add New Category Target')
@section('page-title', 'Create Category Target')

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
            <i class="fa-solid fa-layer-group" style="color: var(--accent);"></i>
            <span>Add New Category Target</span>
        </h2>
        <a href="{{ route('category-targets.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Targets</span>
        </a>
    </div>

    <form action="{{ route('category-targets.store') }}" method="POST">
        @csrf
        
        <div class="form-body">
            <div class="form-group">
                <label class="form-label" for="name">Category Name <span style="color: var(--danger);">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" placeholder="e.g. Real Estate, Travel Companies, Construction" required autofocus>
                @error('name')
                    <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="target_deals">Target Deals Count <span style="color: var(--danger);">*</span></label>
                    <input type="number" id="target_deals" name="target_deals" class="form-input" value="{{ old('target_deals', 30) }}" min="0" required>
                    @error('target_deals')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status <span style="color: var(--danger);">*</span></label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="description">Description / Scope</label>
                <textarea id="description" name="description" class="form-textarea" placeholder="Brief details about target audience and scope...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('category-targets.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-xmark"></i>
                <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-circle-check"></i>
                <span>Create Category Target</span>
            </button>
        </div>
    </form>
</div>
@endsection
