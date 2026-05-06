<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    @stack('head-scripts')
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-deeper: #15803d;
            --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --card: #ffffff; --border: #e2e8f0;
            --muted: #64748b; --gray: #64748b; --gray-light: #f8fafc; --white: #ffffff; --text: #1e293b;
            --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --sidebar-w: 230px; --bg: #eef4fb;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; min-height: 100vh; display: flex; }

        /* ── SIDEBAR ── */
        .sidebar { width: var(--sidebar-w); min-height: 100vh; background: #0f172a; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 50; box-shadow: 4px 0 24px rgba(0,0,0,0.18); }
        .sidebar-logo { display: flex; align-items: center; gap: 10px; padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .logo-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; color: white; box-shadow: 0 4px 12px rgba(34,197,94,0.35); }
        .logo-text { font-weight: 700; font-size: 17px; color: white; }
        .logo-badge { font-size: 9px; background: rgba(34,197,94,0.18); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; padding: 1px 6px; border-radius: 4px; margin-left: auto; font-weight: 700; }
        .sidebar-nav { flex: 1; padding: 0 12px; overflow-y: auto; }
        .nav-label { font-size: 10px; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 0.8px; padding: 0 8px; margin: 16px 0 6px; font-weight: 600; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; text-decoration: none; color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 500; transition: all 0.2s; margin-bottom: 2px; border: 1px solid transparent; }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.9); }
        .nav-item.active { background: linear-gradient(135deg, rgba(34,197,94,0.22), rgba(34,197,94,0.08)); color: #4ade80; font-weight: 600; border-color: rgba(34,197,94,0.2); }
        .nav-item [data-lucide] { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-badge { margin-left: auto; background: #ef4444; color: white; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 10px; line-height: 1.6; }
        .sidebar-footer { padding: 16px 12px 0; border-top: 1px solid rgba(255,255,255,0.07); margin-top: 8px; }
        .admin-chip { display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; margin-bottom: 8px; }
        .admin-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #22c55e, #16a34a); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; flex-shrink: 0; }
        .admin-info { flex: 1; min-width: 0; }
        .admin-name { font-size: 12px; font-weight: 600; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-role { font-size: 10px; color: #4ade80; font-weight: 600; }
        .logout-btn { width: 100%; padding: 9px; background: transparent; border: 1px solid rgba(239,68,68,0.35); border-radius: 8px; color: #f87171; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; cursor: pointer; font-weight: 600; transition: all 0.2s; }
        .logout-btn:hover { background: rgba(239,68,68,0.12); }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; position: relative; z-index: 1; }
        .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; color: var(--dark); }
        .page-sub { font-size: 12px; color: var(--muted); margin-bottom: 24px; }

        /* ── ALERTS ── */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* ── COMMON TABLE ── */
        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--muted); }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 11px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); background: #f8fafc; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: linear-gradient(to right, #f0fdf4, #f8fafc); }
        tbody td { padding: 11px 16px; font-size: 13px; color: var(--text); }
        .user-cell { display: flex; align-items: center; gap: 8px; }
        .user-av { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--green-deeper)); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: white; flex-shrink: 0; }
        .user-name { font-weight: 600; color: var(--dark); }
        .user-email { font-size: 11px; color: var(--muted); }
        .td-muted { color: var(--muted); }
        .td-green { color: var(--green-dark); font-weight: 600; }

        /* ── BADGES ── */
        .badge { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge.Hadir,     .badge.hadir     { background: var(--green-light); color: var(--green-dark); }
        .badge.Terlambat, .badge.terlambat { background: #fef3c7; color: #92400e; }
        .badge.Alfa,      .badge.alfa      { background: #fef2f2; color: var(--red); }
        .badge.Izin,      .badge.izin      { background: #dbeafe; color: #1d4ed8; }

        /* ── MODAL ── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.35); backdrop-filter: blur(3px); z-index: 200; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal { background: var(--white); border: 1px solid var(--border); border-radius: 20px; padding: 28px; width: 100%; max-width: 400px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); animation: fadeUp 0.3s ease both; }
        .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px; font-weight: 800; color: var(--dark); margin-bottom: 6px; }
        .modal-sub { font-size: 13px; color: var(--muted); margin-bottom: 18px; }

        /* ── PAGINATION ── */
        .pagination-wrap { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; }
        .pagination-wrap .pagination { display: flex; gap: 6px; list-style: none; }
        .pagination li a, .pagination li span { padding: 6px 12px; border-radius: 8px; font-size: 12px; text-decoration: none; background: #f8fafc; border: 1.5px solid var(--border); color: var(--text); transition: all 0.2s; }
        .pagination li a:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
        .pagination li.active span { background: var(--green); color: white; border-color: var(--green); font-weight: 700; }

        /* ── FILTER ── */
        .filter-card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .filter-row { display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
        .filter-select, .filter-input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 9px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .filter-select:focus, .filter-input:focus { border-color: var(--green); background: #f0fdf4; }
        .filter-select { min-width: 120px; }
        .filter-input { min-width: 180px; }
        .filter-input::placeholder { color: #94a3b8; }
        .btn-filter { padding: 9px 18px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(34,197,94,0.25); }
        .btn-filter:hover { background: linear-gradient(135deg, #15803d, #16a34a); }
        .btn-reset { padding: 9px 14px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-reset:hover { border-color: #fca5a5; color: #dc2626; background: #fef2f2; }

        /* ── FORMS ── */
        .section-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--muted); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .field { display: flex; flex-direction: column; gap: 6px; }
        .field label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
        .field input, .field select, .field textarea { padding: 9px 14px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--green); background: #f0fdf4; }

        /* ── ANIMATION ── */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        @yield('styles')
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">P</div>
        <span class="logo-text">Presenly</span>
        <span class="logo-badge">ADMIN</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i data-lucide="layout-dashboard"></i> Dashboard</a>
        <a href="{{ route('admin.karyawan') }}" class="nav-item {{ request()->routeIs('admin.karyawan*') ? 'active' : '' }}"><i data-lucide="users"></i> Karyawan</a>
        <a href="{{ route('admin.absensi') }}" class="nav-item {{ request()->routeIs('admin.absensi*') ? 'active' : '' }}"><i data-lucide="clipboard-list"></i> Semua Absensi</a>
        <a href="{{ route('admin.izin') }}" class="nav-item {{ request()->routeIs('admin.izin*') ? 'active' : '' }}"><i data-lucide="file-clock"></i> Izin @if($izinPendingCount > 0)<span class="nav-badge">{{ $izinPendingCount }}</span>@endif</a>
        <a href="{{ route('admin.hari_libur') }}" class="nav-item {{ request()->routeIs('admin.hari_libur*') ? 'active' : '' }}"><i data-lucide="calendar-off"></i> Hari Libur</a>
        <a href="{{ route('admin.lokasi') }}" class="nav-item {{ request()->routeIs('admin.lokasi*') ? 'active' : '' }}"><i data-lucide="map-pin"></i> Lokasi Kerja</a>
        <a href="{{ route('admin.jadwal_mode') }}" class="nav-item {{ request()->routeIs('admin.jadwal_mode*') ? 'active' : '' }}"><i data-lucide="calendar-check"></i> Jadwal Mode Kerja</a>
        <a href="{{ route('admin.pengumuman') }}" class="nav-item {{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}"><i data-lucide="megaphone"></i> Pengumuman</a>
        <a href="{{ route('admin.departemen') }}" class="nav-item {{ request()->routeIs('admin.departemen*') ? 'active' : '' }}"><i data-lucide="building-2"></i> Departemen</a>
        <a href="{{ route('admin.statistik') }}" class="nav-item {{ request()->routeIs('admin.statistik*') ? 'active' : '' }}"><i data-lucide="bar-chart-3"></i> Statistik</a>
        <div class="nav-label">Sistem</div>
        <a href="{{ route('admin.audit_log') }}" class="nav-item {{ request()->routeIs('admin.audit_log*') ? 'active' : '' }}"><i data-lucide="shield-check"></i> Audit Log</a>
        <a href="{{ route('dashboard') }}" class="nav-item"><i data-lucide="smartphone"></i> Absen</a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-chip">
            <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="admin-info">
                <div class="admin-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Keluar</button>
        </form>
    </div>
</aside>

<main class="main">
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<script>lucide.createIcons();</script>
@stack('scripts')
</body>
</html>
