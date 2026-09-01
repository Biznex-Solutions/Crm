<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Biznex CRM</title>
    <meta name="description" content="Sign in to Biznex CRM - Your Intelligent Lead Management Command Center">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Bricolage+Grotesque:wght@700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --accent: #3D5AFE;
            --accent-glow: rgba(61, 90, 254, 0.2);
            --accent-2: #7C3AED;
            --grad: linear-gradient(135deg, #3D5AFE 0%, #7C3AED 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #F0F4FA;
        }

        /* ============================
           LEFT PANEL - Branding
        ============================ */
        .left-panel {
            width: 45%;
            background: var(--grad);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative blobs */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            top: -100px; right: -100px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            bottom: -80px; left: -60px;
        }

        .panel-logo img {
            height: 44px;
            filter: brightness(0) invert(1);
        }

        .panel-content {
            position: relative;
            z-index: 2;
        }

        .panel-tagline {
            font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
            font-size: 40px;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .panel-tagline span {
            display: block;
            opacity: 0.6;
            font-size: 28px;
        }

        .panel-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.75);
            line-height: 1.7;
            max-width: 340px;
        }

        .panel-features {
            display: flex;
            flex-direction: column;
            gap: 14px;
            position: relative;
            z-index: 2;
        }

        .panel-feat-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            font-weight: 500;
        }

        .feat-dot {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: #fff;
            flex-shrink: 0;
        }

        /* ============================
           RIGHT PANEL - Login Form
        ============================ */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box .login-head {
            margin-bottom: 36px;
        }

        .login-box .login-head h2 {
            font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #0A1628;
            letter-spacing: -0.4px;
        }

        .login-box .login-head p {
            font-size: 14px;
            color: #6B7DA3;
            margin-top: 6px;
        }

        .form-grp { margin-bottom: 20px; }

        .form-lbl {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2E4066;
            margin-bottom: 8px;
        }

        .input-wrap { position: relative; }

        .input-wrap .i-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #A0AFCA;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.15s;
        }

        .f-input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 1.5px solid #E4EAF4;
            border-radius: 14px;
            font-size: 14px;
            font-family: inherit;
            color: #0A1628;
            background: #FAFBFF;
            outline: none;
            transition: all 0.2s;
        }

        .f-input:focus {
            border-color: var(--accent);
            background: #fff;
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .f-input:focus + .i-icon {
            color: var(--accent);
        }

        .field-err {
            font-size: 12px;
            font-weight: 600;
            color: #EF4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--grad);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 6px 24px var(--accent-glow);
            transition: all 0.2s ease;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(61, 90, 254, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #E4EAF4;
            text-align: center;
            font-size: 12.5px;
            color: #A0AFCA;
        }

        .login-footer a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .info-banner {
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 860px) {
            .left-panel { display: none; }
            body { align-items: center; justify-content: center; }
            .right-panel { padding: 32px 24px; }
            .login-box { max-width: 100%; }
        }

        @media (max-width: 480px) {
            .right-panel { padding: 24px 18px; }
            .login-box .login-head h2 { font-size: 24px; }
            .btn-login { font-size: 14px; padding: 13px; }
            .f-input { font-size: 15px; }
        }
    </style>
</head>
<body>

    <!-- Left Brand Panel -->
    <div class="left-panel">
        <div class="panel-logo">
            <img src="{{ asset('images/logo.svg') }}" alt="Biznex CRM">
        </div>

        <div class="panel-content">
            <div class="panel-tagline">
                Smart CRM
                <span>for Modern Teams</span>
            </div>
            <p class="panel-desc">
                Manage your leads, track your pipeline, and close more deals with Biznex — the intelligent CRM built for high-performing sales teams.
            </p>
        </div>

        <div class="panel-features">
            <div class="panel-feat-item">
                <div class="feat-dot"><i class="fa-solid fa-bolt"></i></div>
                <span>Instant Lead Capture & Assignment</span>
            </div>
            <div class="panel-feat-item">
                <div class="feat-dot"><i class="fa-solid fa-chart-line"></i></div>
                <span>Real-Time Sales Pipeline Analytics</span>
            </div>
            <div class="panel-feat-item">
                <div class="feat-dot"><i class="fa-solid fa-file-csv"></i></div>
                <span>One-Click Employee Report Export</span>
            </div>
            <div class="panel-feat-item">
                <div class="feat-dot"><i class="fa-solid fa-shield-halved"></i></div>
                <span>Role-Based Secure Access Control</span>
            </div>
        </div>
    </div>

    <!-- Right Form Panel -->
    <div class="right-panel">
        <div class="login-box">
            <div class="login-head">
                <h2>Welcome back 👋</h2>
                <p>Sign in to your Biznex command center</p>
            </div>

            @if(session('info'))
                <div class="info-banner">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-grp">
                    <label class="form-lbl" for="email">Email Address</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email" class="f-input" value="{{ old('email') }}" placeholder="you@biznex.com" required autofocus>
                        <i class="fa-regular fa-envelope i-icon"></i>
                    </div>
                    @error('email')
                        <div class="field-err">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-grp">
                    <label class="form-lbl" for="password">Password</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password" class="f-input" placeholder="••••••••" required>
                        <i class="fa-solid fa-lock i-icon"></i>
                    </div>
                    @error('password')
                        <div class="field-err">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <span>Sign In to Dashboard</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="login-footer">
                &copy; {{ date('Y') }} Biznex CRM &mdash; All rights reserved
            </div>
        </div>
    </div>

</body>
</html>
