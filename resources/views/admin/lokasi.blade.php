<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Kerja – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-deeper: #15803d;
            --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --card: #ffffff; --border: #e2e8f0;
            --muted: #64748b; --white: #ffffff; --text: #1e293b;
            --red: #ef4444; --sidebar-w: 230px; --bg: #eef4fb;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; min-height: 100vh; display: flex; }

                /* SIDEBAR GELAP */
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



        /* MAIN */
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; position: relative; z-index: 1; max-width: 700px; }
        .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; color: var(--dark); }
        .page-sub { font-size: 12px; color: var(--muted); margin-bottom: 24px; }

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* LOKASI CARD */
        .lokasi-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 16px; animation: fadeUp 0.4s ease both; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .lokasi-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .lokasi-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
        .lokasi-id { font-size: 11px; color: var(--muted); background: #f8fafc; border: 1px solid var(--border); padding: 3px 8px; border-radius: 6px; font-weight: 600; }

        /* FORM */
        .field { margin-bottom: 14px; }
        .field label { display: block; font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; margin-bottom: 6px; }
        .field input { width: 100%; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .field input:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
        .field input::placeholder { color: #94a3b8; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn-save { padding: 11px 24px; background: var(--green); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; margin-top: 8px; display: inline-flex; align-items: center; gap: 8px; }
        .btn-save:hover { background: var(--green-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,197,94,0.3); }

        /* COORD DISPLAY */
        .coord-display { display: flex; gap: 8px; margin-bottom: 20px; }
        .coord-chip { flex: 1; background: var(--green-light); border: 1px solid var(--green-mid); border-radius: 10px; padding: 10px 14px; }
        .coord-label { font-size: 10px; color: var(--green-dark); margin-bottom: 3px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
        .coord-val { font-size: 13px; font-weight: 700; color: var(--green-dark); font-variant-numeric: tabular-nums; }

        .empty-state { text-align: center; padding: 48px; color: var(--muted); background: var(--card); border: 1px solid var(--border); border-radius: 16px; font-size: 13px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">P</div>
        <span class="logo-text">Presenly</span>
        <span class="logo-badge">ADMIN</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i data-lucide="layout-dashboard"></i> Dashboard</a>
        <a href="{{ route('admin.karyawan') }}" class="nav-item"><i data-lucide="users"></i> Karyawan</a>
        <a href="{{ route('admin.absensi') }}" class="nav-item"><i data-lucide="clipboard-list"></i> Semua Absensi</a>
        <a href="{{ route('admin.izin') }}" class="nav-item"><i data-lucide="file-clock"></i> Izin @if($izinPendingCount > 0)<span class="nav-badge">{{ $izinPendingCount }}</span>@endif</a>
        <a href="{{ route('admin.hari_libur') }}" class="nav-item"><i data-lucide="calendar-off"></i> Hari Libur</a>
        <a href="{{ route('admin.lokasi') }}" class="nav-item active"><i data-lucide="map-pin"></i> Lokasi Kerja</a>
        <a href="{{ route('admin.jadwal_mode') }}" class="nav-item"><i data-lucide="calendar-check"></i> Jadwal Mode Kerja</a>
        <div class="nav-label">Sistem</div>
        <a href="{{ route('admin.audit_log') }}" class="nav-item"><i data-lucide="shield-check"></i> Audit Log</a>
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
            @csrf <button type="submit" class="logout-btn">Keluar</button>
        </form>
    </div>
</aside>

<main class="main">
    <h1 class="page-title">Lokasi Kerja</h1>
    <p class="page-sub">Edit koordinat GPS dan radius absensi kantor</p>

    @if(session('success'))
        <div class="alert success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error"><i data-lucide="alert-circle"></i> {{ session('error') }}</div>
    @endif

    @forelse($lokasi as $loc)
    <div class="lokasi-card">
        <div class="lokasi-header">
            <span class="lokasi-name"><i data-lucide="map-pin"></i> {{ $loc->nama_lokasi }}</span>
            <span class="lokasi-id">ID #{{ $loc->id }}</span>
        </div>

        <div class="coord-display">
            <div class="coord-chip">
                <div class="coord-label">Latitude</div>
                <div class="coord-val">{{ $loc->latitude }}</div>
            </div>
            <div class="coord-chip">
                <div class="coord-label">Longitude</div>
                <div class="coord-val">{{ $loc->longitude }}</div>
            </div>
            <div class="coord-chip">
                <div class="coord-label">Radius</div>
                <div class="coord-val">{{ $loc->radius_meter }} m</div>
            </div>
            <div class="coord-chip">
                <div class="coord-label">Jam Masuk</div>
                <div class="coord-val">{{ $loc->jam_masuk ? \Carbon\Carbon::parse($loc->jam_masuk)->format('H:i') : '-' }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.lokasi.update', $loc->id) }}">
            @csrf @method('PUT')
            <div class="field">
                <label>Nama Lokasi</label>
                <input type="text" name="nama_lokasi" value="{{ $loc->nama_lokasi }}" required>
            </div>
            <div class="field-row">
                <div class="field">
                    <label>Latitude</label>
                    <input type="text" name="latitude" value="{{ $loc->latitude }}" required placeholder="-0.586230">
                </div>
                <div class="field">
                    <label>Longitude</label>
                    <input type="text" name="longitude" value="{{ $loc->longitude }}" required placeholder="117.046151">
                </div>
            </div>
            <div class="field-row">
                <div class="field">
                    <label>Radius Absensi (meter)</label>
                    <input type="number" name="radius_meter" value="{{ $loc->radius_meter }}" required min="10">
                </div>
                <div class="field">
                    <label>Jam Masuk Standar</label>
                    <input type="time" name="jam_masuk" value="{{ $loc->jam_masuk }}">
                </div>
            </div>
            <button type="submit" class="btn-save"><i data-lucide="save"></i> Simpan Perubahan</button>
        </form>
    </div>
    @empty
    <div class="empty-state">Belum ada data lokasi kerja.</div>
    @endforelse
</main>

<script>lucide.createIcons();</script>
</body>
</html>