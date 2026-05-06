<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil – Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#16a34a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Presenly">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --gray: #64748b; --gray-light: #f8fafc; --white: #ffffff;
            --text: #1e293b; --border: #e2e8f0; --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --nav-h: 60px;
        }
        body { background: #f0f4f8; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; min-height: 100vh; padding-bottom: 80px; }

        .topnav { position: fixed; top: 0; left: 0; right: 0; height: var(--nav-h); background: #0f172a; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; z-index: 100; box-shadow: 0 2px 16px rgba(0,0,0,0.15); }
        .logo { display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .logo-icon { width: 30px; height: 30px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; color: white; box-shadow: 0 3px 10px rgba(34,197,94,0.4); }
        .logo-text { font-size: 16px; font-weight: 800; color: white; letter-spacing: -0.3px; }
        .topnav-right { display: flex; align-items: center; gap: 10px; }
        .user-chip { display: flex; align-items: center; gap: 8px; }
        .user-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--green-dark)); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; }
        .user-name { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.85); }
        .logout-btn { display: flex; align-items: center; gap: 6px; padding: 6px 14px; background: transparent; border: 1px solid rgba(239,68,68,0.4); border-radius: 7px; color: #fca5a5; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .logout-btn:hover { background: rgba(239,68,68,0.12); }
        .logout-btn [data-lucide] { width: 13px; height: 13px; }
        .admin-switch-btn { display: flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 7px; color: rgba(255,255,255,0.85); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; cursor: pointer; }
        .admin-switch-btn:hover { background: rgba(255,255,255,0.18); }
        .admin-switch-btn [data-lucide] { width: 13px; height: 13px; }

        main { padding-top: calc(var(--nav-h) + 20px); padding-bottom: 90px; max-width: 520px; margin: 0 auto; padding-left: 16px; padding-right: 16px; }

        .page-header { margin-bottom: 16px; animation: fadeUp 0.4s ease both; }
        .page-header h1 { font-size: 20px; font-weight: 800; color: var(--dark); letter-spacing: -0.4px; }
        .page-sub { font-size: 12px; color: var(--gray); margin-top: 1px; }

        .card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 18px 20px; margin-bottom: 12px; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
        .card-title-row { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
        .card-title { font-size: 13px; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; }
        .card-title-icon { width: 26px; height: 26px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .card-title-icon.green  { background: var(--green-light); }
        .card-title-icon.purple { background: #ede9fe; }
        .card-title-icon [data-lucide] { width: 13px; height: 13px; stroke-width: 2.5; }
        .card-title-icon.green  [data-lucide] { color: var(--green-dark); }
        .card-title-icon.purple [data-lucide] { color: #7c3aed; }

        .alert { padding: 11px 14px; border-radius: 10px; font-size: 13px; font-weight: 500; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; animation: fadeUp 0.3s ease both; }
        .alert [data-lucide] { width: 16px; height: 16px; flex-shrink: 0; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* PROFILE HERO */
        .profile-hero { padding: 0; overflow: hidden; animation: fadeUp 0.4s 0.05s ease both; border-top: 3px solid var(--green) !important; }
        .profile-hero-banner { height: 80px; background: linear-gradient(135deg, #0f172a 0%, #16a34a 100%); position: relative; }
        .profile-hero-body { padding: 0 20px 24px; text-align: center; }
        .profile-avatar-wrap { position: relative; display: inline-block; margin-top: -38px; margin-bottom: 10px; }
        .profile-avatar-big { width: 76px; height: 76px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--green-dark)); display: flex; align-items: center; justify-content: center; font-size: 30px; font-weight: 800; color: white; box-shadow: 0 8px 24px rgba(34,197,94,0.3); border: 3px solid white; }
        .online-dot { position: absolute; bottom: 4px; right: 4px; width: 14px; height: 14px; background: var(--green); border-radius: 50%; border: 2px solid white; }
        .profile-name { font-size: 18px; font-weight: 800; color: var(--dark); letter-spacing: -0.3px; margin-bottom: 4px; }
        .profile-email { font-size: 13px; color: var(--gray); margin-bottom: 10px; }
        .profile-badges { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; }
        .profile-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; }
        .profile-badge [data-lucide] { width: 12px; height: 12px; }
        .profile-badge.role { background: var(--green-light); color: var(--green-dark); }
        .profile-badge.id { background: var(--gray-light); color: var(--gray); border: 1px solid var(--border); }

        /* STATS */
        .stats-card { animation: fadeUp 0.4s 0.1s ease both; }
        .stats-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        .stat-item { text-align: center; padding: 14px 6px; border-radius: 12px; }
        .stat-item.green  { background: linear-gradient(135deg, #16a34a, #22c55e); box-shadow: 0 4px 14px rgba(34,197,94,0.25); }
        .stat-item.yellow { background: linear-gradient(135deg, #d97706, #f59e0b); box-shadow: 0 4px 14px rgba(245,158,11,0.25); }
        .stat-item.red    { background: linear-gradient(135deg, #dc2626, #ef4444); box-shadow: 0 4px 14px rgba(239,68,68,0.25); }
        .stat-item.blue   { background: linear-gradient(135deg, #2563eb, #3b82f6); box-shadow: 0 4px 14px rgba(59,130,246,0.25); }
        .stat-num { font-size: 24px; font-weight: 800; margin-bottom: 3px; color: white; }
        .stat-label { font-size: 10px; color: rgba(255,255,255,0.85); font-weight: 600; letter-spacing: 0.2px; }

        /* INFO */
        .info-card { animation: fadeUp 0.4s 0.15s ease both; }
        .info-list { display: flex; flex-direction: column; gap: 8px; }
        .info-row { display: flex; align-items: center; justify-content: space-between; padding: 11px 14px; background: #f8fafc; border-radius: 10px; border: 1.5px solid #f1f5f9; transition: all 0.2s; }
        .info-row:hover { border-color: var(--green-mid); background: #f0fdf4; }
        .info-label { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--gray); font-weight: 500; }
        .info-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .info-icon.green  { background: var(--green-light); }
        .info-icon.blue   { background: #dbeafe; }
        .info-icon.purple { background: #ede9fe; }
        .info-icon.yellow { background: #fef3c7; }
        .info-icon [data-lucide] { width: 14px; height: 14px; stroke-width: 2.5; }
        .info-icon.green  [data-lucide] { color: var(--green-dark); }
        .info-icon.blue   [data-lucide] { color: #1d4ed8; }
        .info-icon.purple [data-lucide] { color: #7c3aed; }
        .info-icon.yellow [data-lucide] { color: #92400e; }
        .info-value { font-size: 13px; font-weight: 700; color: var(--dark); }

        /* FORM */
        .form-card { animation: fadeUp 0.4s 0.2s ease both; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: var(--gray); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.4px; }
        .form-control { width: 100%; padding: 10px 14px; background: var(--gray-light); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; outline: none; transition: all 0.2s; }
        .form-control:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
        .form-control::placeholder { color: #94a3b8; }
        .form-error { color: var(--red); font-size: 12px; margin-top: 4px; display: block; }

        .submit-btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(34,197,94,0.3); }
        .submit-btn [data-lucide] { width: 16px; height: 16px; }
        .submit-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(34,197,94,0.4); }
        .submit-btn:active { transform: translateY(0); }

        .section-divider { display: flex; align-items: center; gap: 10px; margin: 20px 0 16px; }
        .section-divider span { font-size: 11px; color: var(--gray); white-space: nowrap; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .section-divider::before, .section-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: var(--white); border-top: 1px solid var(--border); display: flex; box-shadow: 0 -4px 20px rgba(0,0,0,0.08); z-index: 100; padding-bottom: env(safe-area-inset-bottom, 0); }
        .bottom-nav a { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 10px 0; text-decoration: none; color: #94a3b8; font-size: 10px; font-weight: 600; transition: all 0.2s; position: relative; }
        .bottom-nav a.active { color: var(--green-dark); }
        .bottom-nav a:hover { color: var(--green-dark); }
        .bottom-nav a.active::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 28px; height: 3px; background: linear-gradient(90deg, var(--green-dark), var(--green)); border-radius: 0 0 3px 3px; }
        .bottom-nav a [data-lucide] { width: 20px; height: 20px; stroke-width: 2; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

<nav class="topnav">
    <a href="{{ route('home') }}" class="logo">
        <div class="logo-icon">P</div>
        <span class="logo-text">Presenly</span>
    </a>
    <div class="topnav-right">
        <div class="user-chip">
            <div class="user-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
            <span class="user-name">{{ $user->name ?? 'Karyawan' }}</span>
        </div>
        @if(Auth::user()->role_id === 1)
            <a href="{{ route('admin.dashboard') }}" class="admin-switch-btn">
                <i data-lucide="layout-dashboard"></i> Panel Admin
            </a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="logout-btn">
                <i data-lucide="log-out"></i> Keluar
            </button>
        </form>
    </div>
</nav>

<main>

    <div class="page-header">
        <h1>Profil</h1>
        <div class="page-sub">Kelola informasi akun kamu</div>
    </div>

    @if(session('success'))
    <div class="alert success">
        <i data-lucide="check-circle"></i>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert error">
        <i data-lucide="alert-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- PROFILE HERO --}}
    <div class="card profile-hero">
        <div class="profile-hero-banner"></div>
        <div class="profile-hero-body">
            <div class="profile-avatar-wrap">
                <div class="profile-avatar-big">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <span class="online-dot"></span>
            </div>
            <div class="profile-name">{{ $user->name ?? 'Karyawan' }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <div class="profile-badges">
                <span class="profile-badge role">
                    @if($user->role_id == 1)
                        <i data-lucide="shield-check"></i> Admin
                    @else
                        <i data-lucide="user"></i> Karyawan
                    @endif
                </span>
                <span class="profile-badge id">ID #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="card stats-card">
        <div class="card-title-row">
            <span class="card-title">Statistik Keseluruhan</span>
        </div>
        <div class="stats-grid-4">
            <div class="stat-item green">
                <div class="stat-num">{{ $totalHadir ?? 0 }}</div>
                <div class="stat-label">Hadir</div>
            </div>
            <div class="stat-item yellow">
                <div class="stat-num">{{ $totalTerlambat ?? 0 }}</div>
                <div class="stat-label">Terlambat</div>
            </div>
            <div class="stat-item red">
                <div class="stat-num">{{ $totalAlfa ?? 0 }}</div>
                <div class="stat-label">Alfa</div>
            </div>
            <div class="stat-item blue">
                <div class="stat-num">{{ $totalIzin ?? 0 }}</div>
                <div class="stat-label">Izin</div>
            </div>
        </div>
    </div>

    {{-- INFO AKUN --}}
    <div class="card info-card">
        <div class="card-title-row">
            <span class="card-title">Info Akun</span>
        </div>
        <div class="info-list">
            <div class="info-row">
                <div class="info-label">
                    <div class="info-icon blue"><i data-lucide="badge"></i></div>
                    ID Karyawan
                </div>
                <span class="info-value">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <div class="info-icon green"><i data-lucide="calendar"></i></div>
                    Absensi Bulan Ini
                </div>
                <span class="info-value">{{ $bulanIni ?? 0 }} hari</span>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <div class="info-icon purple"><i data-lucide="bar-chart-2"></i></div>
                    Total Absensi
                </div>
                <span class="info-value">{{ $totalAbsensi ?? 0 }} hari</span>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <div class="info-icon yellow"><i data-lucide="calendar-days"></i></div>
                    Absensi Pertama
                </div>
                <span class="info-value">
                    {{ $absensiPertama ? \Carbon\Carbon::parse($absensiPertama->tanggal)->translatedFormat('d M Y') : '-' }}
                </span>
            </div>
        </div>
    </div>

    {{-- EDIT PROFIL + GANTI PASSWORD --}}
    <div class="card form-card">

        <div class="card-title-row">
            <div class="card-title-icon green"><i data-lucide="pencil"></i></div>
            <span class="card-title">Edit Profil</span>
        </div>
        <form method="POST" action="{{ route('profil.update') }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $user->name) }}"
                       placeholder="Nama lengkap" required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $user->email) }}"
                       placeholder="Email" required>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="submit-btn">
                <i data-lucide="save"></i> Simpan Perubahan
            </button>
        </form>

        <div class="section-divider"><span>Keamanan Akun</span></div>

        <div class="card-title-row" style="margin-bottom:14px;">
            <div class="card-title-icon purple"><i data-lucide="shield"></i></div>
            <span class="card-title">Ganti Password</span>
        </div>
        <form method="POST" action="{{ route('profil.password') }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Password Lama</label>
                <input type="password" name="current_password" class="form-control"
                       placeholder="Password saat ini" required>
                @error('current_password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Min. 8 karakter" required>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" class="submit-btn">
                <i data-lucide="key-round"></i> Ganti Password
            </button>
        </form>

    </div>

</main>

<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}">
        <i data-lucide="home"></i>Dashboard
    </a>
    <a href="{{ route('riwayat') }}">
        <i data-lucide="clock"></i>Riwayat
    </a>
    <a href="{{ route('izin.index') }}">
        <i data-lucide="file-text"></i>Izin
    </a>
    <a href="{{ route('profil') }}" class="active">
        <i data-lucide="user"></i>Profil
    </a>
</nav>

<script>lucide.createIcons();</script>
</body>
</html>
