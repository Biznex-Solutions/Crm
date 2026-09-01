<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Biznex CRM') — Business Command Center</title>
    <meta name="description" content="Biznex CRM — Intelligent Lead & Sales Management Platform">

    <!-- Google Fonts: Inter + Bricolage Grotesque -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Bricolage+Grotesque:wght@700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Core Palette */
            --bg-base:        #F0F4FA;
            --bg-card:        #FFFFFF;
            --bg-sidebar:     #FFFFFF;
            --border:         #E4EAF4;
            --border-strong:  #C9D5E8;

            /* Text Hierarchy */
            --text-100: #0A1628;
            --text-200: #2E4066;
            --text-300: #6B7DA3;
            --text-400: #A0AFCA;

            /* Brand */
            --accent:        #3D5AFE;
            --accent-soft:   #EEF1FF;
            --accent-glow:   rgba(61, 90, 254, 0.18);
            --accent-2:      #7C3AED;
            --accent-2-soft: #F3EEFF;
            --success:       #10B981;
            --success-soft:  #D1FAE5;
            --warning:       #F59E0B;
            --warning-soft:  #FEF3C7;
            --danger:        #EF4444;
            --danger-soft:   #FEE2E2;
            --info:          #0EA5E9;
            --info-soft:     #E0F2FE;

            /* Gradients */
            --grad-brand:    linear-gradient(135deg, #3D5AFE 0%, #7C3AED 100%);
            --grad-subtle:   linear-gradient(135deg, #EEF1FF 0%, #F3EEFF 100%);
            --grad-green:    linear-gradient(135deg, #10B981 0%, #059669 100%);
            --grad-orange:   linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            --grad-sky:      linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);

            /* Sidebar */
            --sidebar-w:     268px;

            /* Shadows */
            --shadow-sm:  0 1px 4px rgba(10, 22, 40, 0.06);
            --shadow-md:  0 4px 20px rgba(10, 22, 40, 0.08);
            --shadow-lg:  0 12px 40px rgba(10, 22, 40, 0.12);
            --shadow-glow: 0 8px 32px rgba(61, 90, 254, 0.25);

            /* Radius */
            --r-sm:  8px;
            --r-md:  14px;
            --r-lg:  20px;
            --r-xl:  28px;
        }

        *, *::before, *::after {
            margin: 0; padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-base);
            color: var(--text-100);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ============================
           SIDEBAR
        ============================ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            z-index: 200;
            box-shadow: 4px 0 32px rgba(10, 22, 40, 0.04);
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Custom sidebar scrollbar */
        .sidebar::-webkit-scrollbar { width: 0px; }

        .sidebar-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand img {
            height: 38px;
            width: auto;
        }

        .brand-badge {
            background: var(--grad-brand);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .nav-section {
            padding: 20px 12px 8px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-400);
            padding: 0 10px;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            color: var(--text-300);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: var(--r-md);
            transition: all 0.18s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item i {
            width: 20px;
            font-size: 15px;
            text-align: center;
            flex-shrink: 0;
            transition: transform 0.18s;
        }

        .nav-item:hover {
            background: var(--accent-soft);
            color: var(--accent);
        }

        .nav-item:hover i {
            transform: scale(1.15);
        }

        .nav-item.active {
            background: var(--grad-brand);
            color: #ffffff;
            font-weight: 600;
            box-shadow: var(--shadow-glow);
        }

        .nav-item.active i {
            color: #ffffff;
        }

        /* Sidebar user card at bottom */
        .sidebar-user {
            padding: 14px 16px;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }

        .user-card-inner {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px;
            background: var(--bg-base);
            border-radius: var(--r-md);
            border: 1px solid var(--border);
        }

        .user-av {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--grad-brand);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .user-meta { flex: 1; min-width: 0; }
        .user-meta .uname {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-100);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .role-tag {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 2px 7px;
            border-radius: 20px;
        }
        .role-tag.admin { background: #EDE9FE; color: #6D28D9; }
        .role-tag.employee { background: #DBEAFE; color: #1D4ED8; }

        /* ============================
           MAIN WRAPPER
        ============================ */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* ============================
           TOP HEADER
        ============================ */
        .topbar {
            height: 68px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(10, 22, 40, 0.04);
        }

        .topbar-left h1 {
            font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: var(--text-100);
            letter-spacing: -0.3px;
        }

        .topbar-left .breadcrumb-trail {
            font-size: 12px;
            color: var(--text-400);
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-300);
            background: var(--bg-base);
            padding: 7px 14px;
            border-radius: 30px;
            border: 1px solid var(--border);
        }

        .topbar-date i { color: var(--accent); }

        .btn-change-pwd {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 600;
            color: var(--accent);
            background: var(--accent-soft);
            border: 1px solid #C7D2FE;
            padding: 8px 16px;
            border-radius: var(--r-md);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.18s;
        }

        .btn-change-pwd:hover, .btn-change-pwd.active {
            background: var(--grad-brand);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 4px 14px var(--accent-glow);
        }

        .btn-signout {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 600;
            color: var(--danger);
            background: var(--danger-soft);
            border: 1px solid #FECACA;
            padding: 8px 16px;
            border-radius: var(--r-md);
            cursor: pointer;
            transition: all 0.18s;
        }

        .btn-signout:hover {
            background: var(--danger);
            color: #fff;
            border-color: var(--danger);
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
        }

        /* ============================
           CONTENT AREA
        ============================ */
        .content-area {
            padding: 28px 32px;
            flex: 1;
        }

        /* ============================
           GLOBAL CARDS
        ============================ */
        .card {
            background: var(--bg-card);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-100);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--r-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .card-body { padding: 24px; }

        /* ============================
           STAT CARDS
        ============================ */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: var(--shadow-sm);
            transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            opacity: 0.08;
        }

        .stat-card.c-blue::after { background: var(--accent); }
        .stat-card.c-green::after { background: var(--success); }
        .stat-card.c-orange::after { background: var(--warning); }
        .stat-card.c-purple::after { background: var(--accent-2); }
        .stat-card.c-sky::after { background: var(--info); }

        .stat-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: var(--shadow-md);
            border-color: var(--border-strong);
        }

        .stat-ic {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-ic.c-blue { background: var(--accent-soft); color: var(--accent); }
        .stat-ic.c-green { background: var(--success-soft); color: var(--success); }
        .stat-ic.c-orange { background: var(--warning-soft); color: var(--warning); }
        .stat-ic.c-purple { background: var(--accent-2-soft); color: var(--accent-2); }
        .stat-ic.c-sky { background: var(--info-soft); color: var(--info); }

        .stat-data h3 {
            font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--text-100);
            line-height: 1;
        }

        .stat-data p {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-300);
            margin-top: 4px;
        }

        /* ============================
           GLOBAL TABLE
        ============================ */
        .tbl-wrap {
            overflow-x: auto;
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .tbl thead th {
            background: #F6F9FF;
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-300);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .tbl tbody td {
            padding: 15px 18px;
            color: var(--text-200);
            border-bottom: 1px solid #F0F4FA;
            vertical-align: middle;
        }

        .tbl tbody tr:last-child td { border-bottom: none; }

        .tbl tbody tr {
            transition: background 0.12s;
        }

        .tbl tbody tr:hover td {
            background: #FAFCFF;
        }

        /* ============================
           PILL / BADGE SYSTEM
        ============================ */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 30px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .pill-new { background: var(--info-soft); color: #0369A1; }
        .pill-contacted { background: var(--warning-soft); color: #B45309; }
        .pill-in_progress { background: var(--accent-2-soft); color: #6D28D9; }
        .pill-won { background: var(--success-soft); color: #065F46; }
        .pill-lost { background: var(--danger-soft); color: #991B1B; }

        .badge-admin { background: #EDE9FE; color: #6D28D9; }
        .badge-employee { background: #DBEAFE; color: #1D4ED8; }

        .badge-active { background: var(--success-soft); color: #065F46; }
        .badge-inactive { background: #F1F5F9; color: var(--text-300); }

        /* ============================
           BUTTONS
        ============================ */
        .btn, .btn-primary, .btn-secondary, .btn-success, .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            font-size: 13.5px;
            border-radius: var(--r-md);
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.18s ease;
            font-family: inherit;
            line-height: 1.4;
        }

        .btn-primary {
            background: var(--grad-brand);
            color: #ffffff !important;
            box-shadow: 0 4px 16px var(--accent-glow);
            border: 1px solid transparent;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(61, 90, 254, 0.35);
            color: #ffffff !important;
        }

        .btn-secondary {
            background: var(--bg-card);
            color: var(--text-200) !important;
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-base);
            border-color: var(--border-strong);
            color: var(--text-100) !important;
        }

        .btn-success {
            background: var(--grad-green);
            color: #fff;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        }

        .btn-danger {
            background: var(--danger-soft);
            color: var(--danger);
            border: 1px solid #FECACA;
        }

        .btn-danger:hover {
            background: var(--danger);
            color: #fff;
        }

        .btn-sm {
            padding: 7px 14px;
            font-size: 12.5px;
            border-radius: var(--r-sm);
        }

        .btn-xs {
            padding: 5px 10px;
            font-size: 11.5px;
            border-radius: 8px;
        }

        /* Icon Action Buttons */
        .icon-btn {
            width: 34px;
            height: 34px;
            border-radius: var(--r-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-300);
            text-decoration: none;
            transition: all 0.15s;
        }

        .icon-btn:hover { transform: scale(1.1); }
        .icon-btn.view:hover { background: var(--accent-soft); color: var(--accent); border-color: #C7D2FE; }
        .icon-btn.edit:hover { background: var(--info-soft); color: var(--info); border-color: #BAE6FD; }
        .icon-btn.login:hover { background: var(--accent-2-soft); color: var(--accent-2); border-color: #DDD6FE; }
        .icon-btn.report:hover { background: var(--success-soft); color: var(--success); border-color: #6EE7B7; }
        .icon-btn.toggle:hover { background: var(--warning-soft); color: var(--warning); border-color: #FCD34D; }
        .icon-btn.delete:hover { background: var(--danger-soft); color: var(--danger); border-color: #FECACA; }

        /* ============================
           FORM INPUTS (Global)
        ============================ */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-200);
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
            padding: 11px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--r-md);
            font-size: 14px;
            font-family: inherit;
            color: var(--text-100);
            background: #FAFBFF;
            outline: none;
            transition: all 0.18s;
        }

        .form-control:focus {
            border-color: var(--accent);
            background: #fff;
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .form-control.has-icon { padding-left: 44px; }

        .input-group {
            position: relative;
        }

        .input-group .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-400);
            font-size: 15px;
            pointer-events: none;
        }

        .input-group .form-control:focus ~ .input-icon { color: var(--accent); }

        .field-error {
            font-size: 12px;
            font-weight: 600;
            color: var(--danger);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ============================
           FILTER BAR
        ============================ */
        .filter-bar {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 18px 22px;
            margin-bottom: 22px;
            box-shadow: var(--shadow-sm);
        }

        .filter-bar form {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-bar .f-input {
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--r-md);
            font-size: 13.5px;
            font-family: inherit;
            color: var(--text-100);
            background: var(--bg-base);
            outline: none;
            transition: all 0.15s;
            min-width: 150px;
        }

        .filter-bar .f-input:focus {
            border-color: var(--accent);
            background: #fff;
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .filter-bar .f-search {
            flex: 1;
            min-width: 220px;
        }

        /* ============================
           ALERTS / FLASH
        ============================ */
        .flash {
            padding: 14px 20px;
            border-radius: var(--r-md);
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
            animation: slideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .flash-success { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .flash-error   { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
        .flash-info    { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ============================
           SECTION HEADINGS
        ============================ */
        .section-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .section-hero .hero-text h2 {
            font-family: 'Bricolage Grotesque', 'Inter', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--text-100);
            letter-spacing: -0.3px;
        }

        .section-hero .hero-text p {
            font-size: 13.5px;
            color: var(--text-300);
            margin-top: 3px;
        }

        /* ============================
           AVATAR
        ============================ */
        .avatar {
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
            flex-shrink: 0;
        }

        /* ============================
           PAGINATION
        ============================ */
        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
            flex-wrap: wrap;
        }

        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: var(--r-sm);
            font-size: 13px;
            font-weight: 600;
            color: var(--text-300);
            text-decoration: none;
            border: 1px solid var(--border);
            background: var(--bg-card);
            transition: all 0.15s;
        }

        .pagination a:hover {
            background: var(--accent-soft);
            color: var(--accent);
            border-color: #C7D2FE;
        }

        .pagination .active, .pagination span[aria-current] {
            background: var(--grad-brand);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 10px var(--accent-glow);
        }

        /* ============================
           SCROLLBARS
        ============================ */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-base); }
        ::-webkit-scrollbar-thumb { background: var(--border-strong); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-400); }

        /* ============================
           UTILITY
        ============================ */
        .text-muted   { color: var(--text-300); }
        .text-bold    { font-weight: 700; }
        .text-sm      { font-size: 12.5px; }
        .text-xs      { font-size: 11.5px; }
        .fw-800       { font-weight: 800; }
        .gap-8        { gap: 8px; }
        .d-flex       { display: flex; }
        .ai-center    { align-items: center; }
        .jc-end       { justify-content: flex-end; }
        .action-group { display: flex; align-items: center; gap: 6px; }
        .mb-0         { margin-bottom: 0; }
        .mt-4         { margin-top: 4px; }

        /* ============================
           MOBILE HAMBURGER BUTTON
        ============================ */
        .mob-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: var(--r-sm);
            border: 1.5px solid var(--border);
            background: var(--bg-base);
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: var(--text-200);
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.15s;
        }

        .mob-toggle:hover {
            background: var(--accent-soft);
            color: var(--accent);
            border-color: #C7D2FE;
        }

        /* Sidebar overlay backdrop */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 22, 40, 0.45);
            z-index: 190;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            opacity: 0;
            pointer-events: none;     /* invisible & non-blocking by default */
            transition: opacity 0.25s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: all;      /* clickable when open */
        }

        /* Close button inside sidebar on mobile */
        .sidebar-close {
            display: none;
            position: absolute;
            top: 18px;
            right: 14px;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg-base);
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--text-300);
            cursor: pointer;
        }

        /* ============================
           RESPONSIVE BREAKPOINTS
        ============================ */
        @media (max-width: 1024px) {
            :root { --sidebar-w: 250px; }
            .content-area { padding: 20px 24px; }

            .stats-row {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 14px;
            }

            .topbar { padding: 0 24px; }
        }

        @media (max-width: 900px) {
            /* Sidebar becomes a drawer */
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 200;
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 40px rgba(10, 22, 40, 0.18);
            }

            /* Show close button inside sidebar */
            .sidebar-close { display: flex; }

            /* Main shifts to full width */
            .main-wrap { margin-left: 0; }

            /* Topbar: show hamburger */
            .mob-toggle { display: flex; }

            .topbar { padding: 0 18px; gap: 10px; }
            .topbar-left h1 { font-size: 16px; }

            /* Hide date on mobile */
            .topbar-date { display: none; }

            .btn-change-pwd span { display: none; }
            .btn-change-pwd { padding: 8px 12px; }

            .btn-signout span { display: none; }
            .btn-signout { padding: 8px 12px; }

            /* Content */
            .content-area { padding: 16px; }

            /* Stats cards: 2 column on tablet */
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 18px;
            }

            /* Section hero wrap */
            .section-hero { flex-direction: column; align-items: flex-start; gap: 12px; }

            /* Filter bar */
            .filter-bar { padding: 14px 16px; }
            .filter-bar form { flex-direction: column; align-items: stretch; gap: 10px; }
            .filter-bar .f-input { min-width: unset; width: 100%; }
            .filter-bar .f-search { min-width: unset; }

            /* Cards */
            .card-header { flex-wrap: wrap; gap: 10px; padding: 16px; }
            .card-title { font-size: 14px; gap: 8px; }

            /* Tables: horizontal scroll */
            .tbl-wrap { -webkit-overflow-scrolling: touch; }
            .tbl { min-width: 600px; }

            /* Flash messages */
            .flash-wrap { padding: 0 16px; }
        }

        @media (max-width: 550px) {
            /* Stats: single column on phones */
            .stats-row {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card { padding: 14px 16px; gap: 12px; }
            .stat-ic { width: 42px; height: 42px; font-size: 17px; border-radius: 12px; }
            .stat-data h3 { font-size: 22px; }

            .content-area { padding: 12px; }

            .topbar { height: 60px; }
            .topbar-left h1 { font-size: 15px; }

            /* Buttons text label hidden on xs */
            .btn-sm span { display: inline; }

            /* Banner responsive */
            .dash-banner { padding: 20px; }
            .dash-banner .banner-text h2 { font-size: 18px; }
            .banner-actions { width: 100%; }
            .banner-btn-white, .banner-btn-ghost { flex: 1; justify-content: center; }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="mainSidebar">
        <!-- Mobile close button -->
        <button class="sidebar-close" onclick="closeSidebar()" aria-label="Close menu">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.svg') }}" alt="Biznex">
            <span class="brand-badge">CRM</span>
        </div>

        <div class="nav-section">
            <div class="nav-label">Navigation</div>

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('leads.index') }}" class="nav-item {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                <i class="fa-solid fa-address-book"></i>
                <span>Leads Management</span>
            </a>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Team Members</span>
                </a>

                <a href="{{ route('category-targets.index') }}" class="nav-item {{ request()->routeIs('category-targets.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Category Targets</span>
                </a>

                <a href="{{ route('lead-sources.index') }}" class="nav-item {{ request()->routeIs('lead-sources.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Lead Sources</span>
                </a>

                <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Reports Generator</span>
                </a>
            @endif
        </div>

        <div class="nav-section">
            <div class="nav-label">Quick Actions</div>

            <a href="{{ route('leads.create') }}" class="nav-item">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add New Lead</span>
            </a>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('users.create') }}" class="nav-item">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Add Team Member</span>
                </a>
            @endif

            <a href="{{ route('password.change') }}" class="nav-item {{ request()->routeIs('password.*') ? 'active' : '' }}">
                <i class="fa-solid fa-key"></i>
                <span>Change Password</span>
            </a>
        </div>

        <div class="sidebar-user">
            <a href="{{ route('password.change') }}" class="user-card-inner" style="text-decoration: none;" title="Manage Account & Password">
                <div class="user-av">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-meta">
                    <div class="uname">{{ Auth::user()->name ?? 'User' }}</div>
                    <span class="role-tag {{ Auth::user()->role ?? 'employee' }}">
                        {{ ucfirst(Auth::user()->role ?? 'employee') }}
                    </span>
                </div>
                <i class="fa-solid fa-gear" style="color: var(--text-400); font-size: 14px; margin-left: auto;"></i>
            </a>
        </div>
    </aside>

    <!-- ===== MAIN ===== -->
    <div class="main-wrap">
        <!-- Top Header -->
        <header class="topbar">
            <!-- Hamburger (mobile only) -->
            <button class="mob-toggle" onclick="openSidebar()" aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="topbar-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="topbar-right">
                <div class="topbar-date">
                    <i class="fa-regular fa-calendar"></i>
                    {{ now()->format('D, d M Y') }}
                </div>

                <a href="{{ route('password.change') }}" class="btn-change-pwd {{ request()->routeIs('password.*') ? 'active' : '' }}" title="Change Password">
                    <i class="fa-solid fa-key"></i>
                    <span>Change Password</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-signout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="flash-wrap" style="padding: 0 32px;">
            @if(session('success'))
                <div class="flash flash-success" style="margin-top: 20px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="flash flash-error" style="margin-top: 20px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar  = document.getElementById('mainSidebar');
            var overlay  = document.getElementById('sidebarOverlay');
            var openBtn  = document.querySelector('.mob-toggle');
            var closeBtn = document.querySelector('.sidebar-close');

            if (!sidebar || !overlay) return;

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Hamburger open button
            if (openBtn) openBtn.addEventListener('click', openSidebar);

            // ✕ close button inside sidebar
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

            // Clicking overlay closes sidebar
            overlay.addEventListener('click', closeSidebar);

            // Tapping any nav link on mobile closes sidebar
            document.querySelectorAll('.nav-item').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 900) closeSidebar();
                });
            });

            // Auto-close on resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 900) closeSidebar();
            });

            // Make functions globally accessible for any inline usage
            window.openSidebar  = openSidebar;
            window.closeSidebar = closeSidebar;
        });
    </script>
</body>
</html>
