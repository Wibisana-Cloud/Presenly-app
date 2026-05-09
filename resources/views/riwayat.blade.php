<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absensi – Presenly</title>
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

        main { padding-top: calc(var(--nav-h) + 20px); padding-bottom: 90px; max-width: 520px; margin: 0 auto; padding-left: 16px; padding-right: 16px; }

        .page-header { margin-bottom: 16px; animation: fadeUp 0.4s ease both; }
        .page-header h1 { font-size: 20px; font-weight: 800; color: var(--dark); letter-spacing: -0.4px; }
        .page-sub { font-size: 12px; color: var(--gray); margin-top: 1px; }

        .card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 18px 20px; margin-bottom: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .card-title-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .card-title { font-size: 13px; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; }

        .stats-card { animation: fadeUp 0.4s 0.05s ease both; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        .stat-item { text-align: center; padding: 14px 6px; border-radius: 12px; }
        .stat-item.green  { background: linear-gradient(135deg, #16a34a, #22c55e); box-shadow: 0 4px 14px rgba(34,197,94,0.25); }
        .stat-item.yellow { background: linear-gradient(135deg, #d97706, #f59e0b); box-shadow: 0 4px 14px rgba(245,158,11,0.25); }
        .stat-item.red    { background: linear-gradient(135deg, #dc2626, #ef4444); box-shadow: 0 4px 14px rgba(239,68,68,0.25); }
        .stat-item.blue   { background: linear-gradient(135deg, #2563eb, #3b82f6); box-shadow: 0 4px 14px rgba(59,130,246,0.25); }
        .stat-num { font-size: 24px; font-weight: 800; margin-bottom: 3px; color: white; }
        .stat-label { font-size: 10px; color: rgba(255,255,255,0.85); font-weight: 600; letter-spacing: 0.2px; }

        .filter-card { animation: fadeUp 0.4s 0.1s ease both; }
        .filter-row { display: flex; gap: 8px; flex-wrap: wrap; }
        .filter-select { flex: 1; padding: 9px 12px; background: var(--gray-light); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; cursor: pointer; }
        .filter-select:focus { border-color: var(--green); }
        .filter-btn { display: flex; align-items: center; gap: 6px; padding: 9px 18px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 3px 10px rgba(34,197,94,0.3); }
        .filter-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(34,197,94,0.4); }
        .filter-btn [data-lucide] { width: 14px; height: 14px; }
        .export-row { display: flex; gap: 8px; margin-top: 10px; }
        .export-btn { flex: 1; padding: 9px; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; text-decoration: none; text-align: center; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .export-btn [data-lucide] { width: 14px; height: 14px; }
        .export-btn.pdf { background: #fef2f2; border: 1.5px solid #fecaca; color: var(--red); }
        .export-btn.pdf:hover { background: #fee2e2; }
        .export-btn.csv { background: var(--green-light); border: 1.5px solid var(--green-mid); color: var(--green-dark); }
        .export-btn.csv:hover { background: var(--green-mid); }

        .table-card { animation: fadeUp 0.4s 0.15s ease both; background: var(--white); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-header { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray); }
        .list-count { font-size: 12px; color: var(--gray); background: var(--gray-light); border: 1px solid var(--border); border-radius: 20px; padding: 2px 10px; font-weight: 600; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 10px 14px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray); font-weight: 600; border-bottom: 1px solid var(--border); background: #f8fafc; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: linear-gradient(to right, #f0fdf4, #f8fafc); }
        tbody td { padding: 10px 14px; font-size: 13px; color: var(--text); }
        .td-muted { color: var(--gray); }
        .td-green { color: var(--green-dark); font-weight: 600; }
        .td-tanggal { font-weight: 600; color: var(--dark); font-size: 12px; }
        .td-hari { font-size: 10px; color: var(--gray); margin-top: 1px; }

        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-state-icon { width: 64px; height: 64px; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .empty-state-icon svg { width: 30px; height: 30px; stroke: #16a34a; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .empty-state-title { font-size: 15px; font-weight: 700; color: var(--dark); margin-bottom: 6px; }
        .empty-state-sub { font-size: 13px; color: var(--gray); }

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
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
            <span class="user-name">{{ Auth::user()->name ?? 'Karyawan' }}</span>
        </div>
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
        <h1>Riwayat Absensi</h1>
        <div class="page-sub">
            {{ \Carbon\Carbon::createFromDate(null, (int) $bulan)->translatedFormat('F') }} {{ $tahun }}
        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="card stats-card">
        <div class="card-title-row">
            <span class="card-title">Ringkasan</span>
            <span style="font-size:11px;color:var(--gray);background:var(--gray-light);border:1px solid var(--border);border-radius:6px;padding:2px 8px;">
                {{ \Carbon\Carbon::createFromDate(null, (int) $bulan)->translatedFormat('F') }} {{ $tahun }}
            </span>
        </div>
        <div class="stats-grid">
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

    {{-- FILTER & EXPORT --}}
    <div class="card filter-card">
        <div class="card-title-row">
            <span class="card-title">Filter Periode</span>
        </div>
        <form method="GET" action="{{ route('riwayat') }}">
            <div class="filter-row">
                <select name="bulan" class="filter-select">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ ($bulan == $i) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(null, (int) $i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="tahun" class="filter-select">
                    @foreach($tahunList as $y)
                        <option value="{{ $y }}" {{ ($tahun == $y) ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-btn">
                    <i data-lucide="search"></i> Filter
                </button>
            </div>
        </form>
        <div class="export-row">
            <a href="{{ route('riwayat.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="export-btn pdf">
                <i data-lucide="file-text"></i> Export PDF
            </a>
            <a href="{{ route('riwayat.export.csv', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="export-btn csv">
                <i data-lucide="download"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- LIST --}}
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Data Absensi</span>
            <span class="list-count">{{ $riwayat->count() }} data</span>
        </div>

        @if($riwayat->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon"><svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
            <div class="empty-state-title">Belum ada data absensi</div>
            <div class="empty-state-sub">Tidak ada catatan absensi untuk periode yang dipilih</div>
        </div>
        @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $i => $item)
                    <tr>
                        <td class="td-muted">{{ $i + 1 }}</td>
                        <td>
                            <div class="td-tanggal">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</div>
                            <div class="td-hari">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</div>
                        </td>
                        <td class="td-green">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
                        <td class="td-muted">{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
                        <td class="td-muted">{{ $item->durasi_kerja ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</main>

<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}">
        <i data-lucide="home"></i>Dashboard
    </a>
    <a href="{{ route('riwayat') }}" class="active">
        <i data-lucide="clock"></i>Riwayat
    </a>
    <a href="{{ route('izin.index') }}">
        <i data-lucide="file-text"></i>Izin
    </a>
    <a href="{{ route('profil') }}">
        <i data-lucide="user"></i>Profil
    </a>
</nav>

<script>lucide.createIcons();</script>
</body>
</html>
