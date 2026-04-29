<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayrollSIS — @yield('title', 'Dashboard')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #1a1a1a; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 220px; flex-shrink: 0; background: #fff; border-right: 1px solid #e8e8e8; display: flex; flex-direction: column; position: fixed; height: 100vh; }
        .logo { padding: 18px 20px; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #e8e8e8; }
        .logo-icon { width: 30px; height: 30px; background: #185FA5; border-radius: 7px; display: flex; align-items: center; justify-content: center; }
        .logo-icon svg { width: 16px; height: 16px; stroke: white; fill: none; }
        .nav { padding: 12px 0; flex: 1; }
        .nav-label { font-size: 10.5px; color: #999; padding: 10px 20px 4px; letter-spacing: 0.07em; text-transform: uppercase; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 20px; font-size: 13.5px; color: #555; text-decoration: none; border-left: 2.5px solid transparent; transition: all 0.15s; }
        .nav-item:hover { background: #f7f7f7; color: #1a1a1a; }
        .nav-item.active { color: #185FA5; border-left-color: #185FA5; background: #EBF3FC; font-weight: 500; }
        .nav-item svg { width: 16px; height: 16px; stroke: currentColor; fill: none; flex-shrink: 0; }

        /* Main */
        .main { flex: 1; margin-left: 220px; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e8e8e8; padding: 0 24px; height: 54px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 10; }
        .topbar-title { font-size: 15px; font-weight: 600; color: #1a1a1a; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .avatar { width: 34px; height: 34px; border-radius: 50%; background: #185FA5; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: white; }
        .admin-name { font-size: 13px; color: #555; }
        .content { padding: 24px; flex: 1; }

        /* Komponen umum */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; border: 1px solid #ddd; background: #fff; color: #1a1a1a; font-size: 13px; cursor: pointer; text-decoration: none; transition: all 0.15s; }
        .btn:hover { background: #f5f5f5; }
        .btn-primary { background: #185FA5; border-color: #185FA5; color: white; }
        .btn-primary:hover { background: #0C447C; }
        .btn-danger { background: #fff; border-color: #E24B4A; color: #E24B4A; }
        .btn-danger:hover { background: #FCEBEB; }
        .btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; }

        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 500; }
        .badge-success { background: #EAF3DE; color: #3B6D11; }
        .badge-warning { background: #FAEEDA; color: #854F0B; }
        .badge-info { background: #E6F1FB; color: #185FA5; }
        .badge-danger { background: #FCEBEB; color: #A32D2D; }

        .card { background: #fff; border-radius: 12px; border: 1px solid #e8e8e8; margin-bottom: 20px; }
        .card-head { padding: 14px 20px; border-bottom: 1px solid #e8e8e8; display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 14px; font-weight: 600; color: #1a1a1a; }
        .card-body { padding: 20px; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 10px 20px; font-size: 11px; color: #888; font-weight: 600; border-bottom: 1px solid #e8e8e8; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 11px 20px; color: #1a1a1a; border-bottom: 1px solid #f0f0f0; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafafa; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12.5px; color: #555; margin-bottom: 6px; font-weight: 500; }
        .form-control { width: 100%; font-size: 13px; padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; background: #fff; color: #1a1a1a; outline: none; transition: border-color 0.15s; }
        .form-control:focus { border-color: #185FA5; }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 32px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-actions { padding: 16px 20px; border-top: 1px solid #e8e8e8; display: flex; justify-content: flex-end; gap: 10px; }

        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .alert-success { background: #EAF3DE; color: #3B6D11; border: 1px solid #C0DD97; }
        .alert-danger { background: #FCEBEB; color: #A32D2D; border: 1px solid #F7C1C1; }

        .emp-avatar { width: 30px; height: 30px; border-radius: 50%; background: #E6F1FB; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: #185FA5; margin-right: 8px; vertical-align: middle; }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <div class="logo-icon">
            <svg viewBox="0 0 16 16"><rect x="2" y="2" width="5" height="5" rx="1"/><rect x="9" y="2" width="5" height="5" rx="1"/><rect x="2" y="9" width="5" height="5" rx="1"/><rect x="9" y="9" width="5" height="5" rx="1"/></svg>
        </div>
        PayrollSIS
    </div>
    <nav class="nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 16 16"><rect x="1" y="1" width="6" height="6" rx="1"/><rect x="9" y="1" width="6" height="6" rx="1"/><rect x="1" y="9" width="6" height="6" rx="1"/><rect x="9" y="9" width="6" height="6" rx="1"/></svg>
            Dashboard
        </a>
        <a href="{{ route('employees.index') }}" class="nav-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <svg viewBox="0 0 16 16"><circle cx="8" cy="5" r="3"/><path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
            Data Karyawan
        </a>
        <a href="{{ route('payrolls.index') }}" class="nav-item {{ request()->routeIs('payrolls.*') ? 'active' : '' }}">
            <svg viewBox="0 0 16 16"><rect x="2" y="2" width="12" height="12" rx="1.5"/><path d="M5 8h6M5 11h4M5 5h6"/></svg>
            Penggajian
        </a>
    </nav>
</div>

<div class="main">
    <div class="topbar">
        <div class="topbar-title">@yield('title', 'Dashboard')</div>
        <div class="topbar-right">
            <span class="admin-name">Admin</span>
            <div class="avatar">AD</div>
        </div>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error) {{ $error }}<br> @endforeach
            </div>
        @endif
        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
