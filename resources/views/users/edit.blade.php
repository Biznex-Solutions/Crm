@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User Profile')

@section('content')
<style>
    .form-card {
        background: #FFFFFF;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        padding: 36px;
        max-width: 840px;
        margin: 0 auto;
    }

    .form-header-title {
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-header-title h2 {
        font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: var(--text-100);
    }

    .form-header-title p {
        font-size: 14px;
        color: var(--text-300);
        margin-top: 4px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .full-width {
        grid-column: span 2;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-200);
    }

    .form-input, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        font-size: 14px;
        color: var(--text-100);
        background: #FAFBFF;
        outline: none;
        transition: all 0.2s;
        font-family: inherit;
    }

    .form-input:focus, .form-select:focus {
        background: #FFFFFF;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .role-options-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .role-card-option {
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 14px;
        background: #FAFBFF;
    }

    .role-card-option:hover {
        border-color: var(--border-strong);
    }

    .role-card-option input[type="radio"] {
        accent-color: var(--accent);
        width: 18px;
        height: 18px;
    }

    .role-card-option.selected {
        border-color: var(--accent);
        background: var(--accent-soft);
    }

    .role-info .title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-100);
    }

    .role-info .desc {
        font-size: 12px;
        color: var(--text-300);
        margin-top: 2px;
    }

    .cat-check-item:hover {
        border-color: var(--accent) !important;
        background: var(--accent-soft) !important;
    }

    .error-msg {
        color: var(--danger);
        font-size: 12px;
        font-weight: 600;
    }

    .form-footer-actions {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 16px;
    }
</style>

<div class="form-card">
    <div class="form-header-title">
        <div>
            <h2><i class="fa-solid fa-pen-to-square" style="color: var(--accent); margin-right: 8px;"></i> Edit User: {{ $user->name }}</h2>
            <p>Update user details, role privileges, assigned category targets, or active/inactive status.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary" style="padding: 8px 14px; font-size: 13px;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Name -->
            <div class="form-group">
                <label class="form-label" for="name">Full Name <span style="color: var(--danger);">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address <span style="color: var(--danger);">*</span></label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Designation -->
            <div class="form-group">
                <label class="form-label" for="designation">Job Title / Designation</label>
                <input type="text" id="designation" name="designation" class="form-input" value="{{ old('designation', $user->designation) }}">
                @error('designation') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Optional Password Change -->
            <div class="form-group">
                <label class="form-label" for="password">New Password <span style="font-weight: 500; color: var(--text-300);">(Leave blank to keep unchanged)</span></label>
                <input type="password" id="password" name="password" class="form-input" placeholder="New password (optional)">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Repeat new password">
            </div>

            <!-- Role Selection -->
            <div class="form-group full-width">
                <label class="form-label">User Role <span style="color: var(--danger);">*</span></label>
                <div class="role-options-grid">
                    <label class="role-card-option {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}" onclick="selectRole(this)">
                        <input type="radio" name="role" value="employee" {{ old('role', $user->role) == 'employee' ? 'checked' : '' }} required>
                        <div class="role-info">
                            <div class="title"><i class="fa-solid fa-user-tie" style="color: #2563EB; margin-right: 6px;"></i> Employee Role</div>
                            <div class="desc">Standard staff member privileges & assigned category targets</div>
                        </div>
                    </label>

                    <label class="role-card-option {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}" onclick="selectRole(this)">
                        <input type="radio" name="role" value="admin" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }} required>
                        <div class="role-info">
                            <div class="title"><i class="fa-solid fa-user-shield" style="color: #7C3AED; margin-right: 6px;"></i> Admin Role</div>
                            <div class="desc">Full administrative access & all category targets</div>
                        </div>
                    </label>
                </div>
                @error('role') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Multiple Target Categories Selection for Employee -->
            @php
                $assignedIds = old('category_target_ids', $user->categoryTargets->pluck('id')->toArray());
            @endphp
            <div class="form-group full-width" id="categoryTargetWrapper" style="{{ old('role', $user->role) === 'admin' ? 'display:none;' : '' }}">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; flex-wrap: wrap; gap: 8px;">
                    <label class="form-label" style="margin-bottom: 0;">
                        <i class="fa-solid fa-layer-group" style="color: var(--accent); margin-right: 4px;"></i>
                        Assigned Target Categories <span style="font-weight: 500; color: var(--text-300);">(Select multiple)</span>
                    </label>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn btn-xs btn-secondary" onclick="toggleAllCategories(true)">
                            <i class="fa-solid fa-check-double"></i> Select All
                        </button>
                        <button type="button" class="btn btn-xs btn-secondary" onclick="toggleAllCategories(false)">
                            <i class="fa-solid fa-xmark"></i> Clear All
                        </button>
                    </div>
                </div>

                <div class="category-checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 10px; max-height: 260px; overflow-y: auto; padding: 12px; background: #FAFBFF; border: 1.5px solid var(--border); border-radius: 14px;">
                    @foreach($categories as $category)
                        <label class="cat-check-item" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; cursor: pointer; transition: all 0.15s;">
                            <input type="checkbox" name="category_target_ids[]" value="{{ $category->id }}" class="cat-checkbox" {{ in_array($category->id, $assignedIds) ? 'checked' : '' }} style="accent-color: var(--accent); width: 16px; height: 16px; flex-shrink: 0;">
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-100); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $category->name }}</div>
                                <div style="font-size: 11px; color: var(--text-300);">Target: {{ $category->target_deals }} deals</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                <span style="font-size: 12px; color: var(--text-300); margin-top: 4px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-circle-info" style="color: var(--accent);"></i> When this employee creates leads, they will be restricted to the selected target categories.
                </span>
                @error('category_target_ids') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Account Status -->
            <div class="form-group full-width">
                <label class="form-label" for="status">Account Status <span style="color: var(--danger);">*</span></label>
                <select id="status" name="status" class="form-select" required>
                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active (User can sign in)</option>
                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive (Access disabled)</option>
                </select>
                @error('status') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-footer-actions">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-xmark"></i>
                <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-arrows-rotate"></i>
                <span>Update User Changes</span>
            </button>
        </div>
    </form>
</div>

<script>
    function selectRole(element) {
        document.querySelectorAll('.role-card-option').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        var roleVal = element.querySelector('input[type="radio"]').value;
        var categoryWrapper = document.getElementById('categoryTargetWrapper');
        if (categoryWrapper) {
            if (roleVal === 'employee') {
                categoryWrapper.style.display = 'flex';
            } else {
                categoryWrapper.style.display = 'none';
            }
        }
    }

    function toggleAllCategories(check) {
        document.querySelectorAll('.cat-checkbox').forEach(cb => cb.checked = check);
    }
</script>
@endsection
