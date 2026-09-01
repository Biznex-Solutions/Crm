@extends('layouts.app')

@section('title', 'Change Password')
@section('page-title', 'Change Password & Security')

@section('content')
<style>
    .security-layout {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 24px;
        max-width: 1060px;
        margin: 0 auto;
    }

    .form-card {
        background: #FFFFFF;
        border-radius: var(--r-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        padding: 32px;
    }

    .card-header-block {
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--grad-brand);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 14px var(--accent-glow);
        flex-shrink: 0;
    }

    .header-text h2 {
        font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: var(--text-100);
        letter-spacing: -0.3px;
    }

    .header-text p {
        font-size: 13.5px;
        color: var(--text-300);
        margin-top: 2px;
    }

    .form-field-group {
        margin-bottom: 22px;
    }

    .form-field-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-200);
        margin-bottom: 8px;
    }

    .pwd-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .pwd-input-wrap .left-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-400);
        font-size: 15px;
        pointer-events: none;
        transition: color 0.18s;
    }

    .pwd-input-wrap input {
        width: 100%;
        padding: 12px 46px 12px 44px;
        border: 1.5px solid var(--border);
        border-radius: var(--r-md);
        font-size: 14px;
        font-family: inherit;
        color: var(--text-100);
        background: #FAFBFF;
        outline: none;
        transition: all 0.18s;
    }

    .pwd-input-wrap input:focus {
        border-color: var(--accent);
        background: #FFFFFF;
        box-shadow: 0 0 0 4px var(--accent-glow);
    }

    .pwd-input-wrap input:focus ~ .left-icon {
        color: var(--accent);
    }

    .pwd-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-400);
        cursor: pointer;
        padding: 6px 8px;
        font-size: 15px;
        border-radius: 6px;
        transition: color 0.15s, background 0.15s;
    }

    .pwd-toggle-btn:hover {
        color: var(--text-100);
        background: var(--bg-base);
    }

    .field-error-msg {
        font-size: 12px;
        font-weight: 600;
        color: var(--danger);
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Live Password Checklist */
    .pwd-checklist {
        margin-top: 10px;
        padding: 12px 16px;
        background: var(--bg-base);
        border: 1px solid var(--border);
        border-radius: var(--r-md);
        font-size: 12px;
    }

    .checklist-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-300);
        margin-bottom: 5px;
        transition: color 0.18s;
    }

    .checklist-item:last-child {
        margin-bottom: 0;
    }

    .checklist-item i {
        font-size: 13px;
        width: 14px;
        text-align: center;
    }

    .checklist-item.valid {
        color: var(--success);
        font-weight: 600;
    }

    .checklist-item.valid i {
        color: var(--success);
    }

    /* Security Sidebar Card */
    .security-info-card {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .side-card {
        background: #FFFFFF;
        border-radius: var(--r-lg);
        border: 1px solid var(--border);
        padding: 24px;
        box-shadow: var(--shadow-sm);
    }

    .side-card-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text-100);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .side-card-title i {
        color: var(--accent);
    }

    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .tips-list li {
        font-size: 12.5px;
        color: var(--text-200);
        line-height: 1.5;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .tips-list li i {
        color: var(--accent-2);
        margin-top: 3px;
        flex-shrink: 0;
    }

    .user-info-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        background: var(--bg-base);
        border: 1px solid var(--border);
        border-radius: var(--r-md);
    }

    .user-info-pill .u-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--grad-brand);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
    }

    .user-info-pill .u-details .u-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-100);
    }

    .user-info-pill .u-details .u-email {
        font-size: 11.5px;
        color: var(--text-300);
    }

    .form-actions-bar {
        margin-top: 32px;
        padding-top: 22px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    @media (max-width: 900px) {
        .security-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="security-layout">
    <!-- Left Main: Change Password Form -->
    <div class="form-card">
        <div class="card-header-block">
            <div class="header-icon">
                <i class="fa-solid fa-key"></i>
            </div>
            <div class="header-text">
                <h2>Update Account Password</h2>
                <p>Ensure your account stays protected by choosing a strong, unique password.</p>
            </div>
        </div>

        <form action="{{ route('password.update') }}" method="POST" id="changePasswordForm">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="form-field-group">
                <label class="form-field-label" for="current_password">
                    Current Password <span style="color: var(--danger);">*</span>
                </label>
                <div class="pwd-input-wrap">
                    <input type="password" id="current_password" name="current_password" placeholder="Enter your current password" required autofocus>
                    <i class="fa-solid fa-lock left-icon"></i>
                    <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('current_password', this)" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('current_password')
                    <div class="field-error-msg">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="form-field-group">
                <label class="form-field-label" for="new_password">
                    New Password <span style="color: var(--danger);">*</span>
                </label>
                <div class="pwd-input-wrap">
                    <input type="password" id="new_password" name="password" placeholder="Minimum 8 characters" required>
                    <i class="fa-solid fa-shield-halved left-icon"></i>
                    <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('new_password', this)" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="field-error-msg">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                <!-- Password Rules Checklist -->
                <div class="pwd-checklist">
                    <div class="checklist-item" id="rule-min-length">
                        <i class="fa-regular fa-circle"></i>
                        <span>At least 8 characters long</span>
                    </div>
                    <div class="checklist-item" id="rule-different">
                        <i class="fa-regular fa-circle"></i>
                        <span>Different from current password</span>
                    </div>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div class="form-field-group">
                <label class="form-field-label" for="password_confirmation">
                    Confirm New Password <span style="color: var(--danger);">*</span>
                </label>
                <div class="pwd-input-wrap">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your new password" required>
                    <i class="fa-solid fa-check-double left-icon"></i>
                    <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('password_confirmation', this)" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                <div class="checklist-item" id="rule-match" style="margin-top: 8px; font-size: 12px; padding: 0 4px;">
                    <i class="fa-regular fa-circle"></i>
                    <span>Passwords must match</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions-bar">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Cancel</span>
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fa-solid fa-shield-check"></i>
                    <span>Update Password</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Account Status & Security Tips -->
    <div class="security-info-card">
        <!-- Account Overview -->
        <div class="side-card">
            <div class="side-card-title">
                <i class="fa-solid fa-user-shield"></i>
                <span>Active Account</span>
            </div>
            <div class="user-info-pill">
                <div class="u-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="u-details">
                    <div class="u-name">{{ Auth::user()->name }}</div>
                    <div class="u-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div style="margin-top: 14px; font-size: 12px; color: var(--text-300); display: flex; justify-content: space-between;">
                <span>Role: <strong style="color: var(--text-200);">{{ ucfirst(Auth::user()->role) }}</strong></span>
                <span>Status: <span class="badge-active" style="padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 700;">Active</span></span>
            </div>
        </div>

        <!-- Security Best Practices -->
        <div class="side-card">
            <div class="side-card-title">
                <i class="fa-solid fa-lightbulb"></i>
                <span>Security Recommendations</span>
            </div>
            <ul class="tips-list">
                <li>
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Use a combination of letters, numbers, and special symbols for enhanced safety.</span>
                </li>
                <li>
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Avoid using easy-to-guess words, personal birthdays, or common phrases.</span>
                </li>
                <li>
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Never share your password with anyone or reuse passwords from other platforms.</span>
                </li>
                <li>
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Always sign out when using shared or public workstations.</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function togglePasswordVisibility(inputId, btn) {
        var input = document.getElementById(inputId);
        var icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var currentPwdInput = document.getElementById('current_password');
        var newPwdInput = document.getElementById('new_password');
        var confirmPwdInput = document.getElementById('password_confirmation');

        var ruleMinLength = document.getElementById('rule-min-length');
        var ruleDifferent = document.getElementById('rule-different');
        var ruleMatch = document.getElementById('rule-match');

        function updateChecklist() {
            var currentVal = currentPwdInput.value;
            var newVal = newPwdInput.value;
            var confirmVal = confirmPwdInput.value;

            // Min length check
            if (newVal.length >= 8) {
                setRuleValid(ruleMinLength, true);
            } else {
                setRuleValid(ruleMinLength, false);
            }

            // Different from current check
            if (newVal.length > 0 && currentVal.length > 0 && newVal !== currentVal) {
                setRuleValid(ruleDifferent, true);
            } else {
                setRuleValid(ruleDifferent, false);
            }

            // Match check
            if (confirmVal.length > 0 && newVal === confirmVal) {
                setRuleValid(ruleMatch, true);
            } else {
                setRuleValid(ruleMatch, false);
            }
        }

        function setRuleValid(element, isValid) {
            if (!element) return;
            var icon = element.querySelector('i');
            if (isValid) {
                element.classList.add('valid');
                if (icon) {
                    icon.className = 'fa-solid fa-circle-check';
                }
            } else {
                element.classList.remove('valid');
                if (icon) {
                    icon.className = 'fa-regular fa-circle';
                }
            }
        }

        currentPwdInput.addEventListener('input', updateChecklist);
        newPwdInput.addEventListener('input', updateChecklist);
        confirmPwdInput.addEventListener('input', updateChecklist);
    });
</script>
@endsection
@endsection
