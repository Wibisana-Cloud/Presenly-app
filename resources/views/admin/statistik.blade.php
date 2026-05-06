<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Keterlambatan – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --card: #ffffff; --border: #e2e8f0;
            --muted: #64748b; --text: #1e293b; --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --sidebar-w: 230px; --bg: #eef4fb;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; min-height: 100vh; display: flex; }
        .sidebar { width: var(--sidebar-w); min-height: 100vh; background: #0f172a; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 50; box-shadow: 4px 0 24px rgba(0,0,0,0.18); }
        .sidebar-logo { display: flex; align-items: center; gap: 10px; padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .logo-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; color: white; }
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
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; }
        .page-title { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; color: var(--dark); }
        .page-sub { font-size: 12px; color: var(--muted); margin-bottom: 24px; }
        .filter-card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .filter-row { display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
        .filter-select { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 9px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; min-width: 120px; }
        .filter-select:focus { border-color: var(--green); background: #f0fdf4; }
        .btn-filter { padding: 9px 18px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 8px rgba(34,197,94,0.25); }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--muted); }
        .card-body { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 11px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); background: #f8fafc; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f0fdf4; }
        tbody td { padding: 11px 16px; font-size: 13px; }
        .user-cell { display: flex; align-items: center; gap: 8px; }
        .user-av { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, var(--green), #15803d); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: white; flex-shrink: 0; }
        .user-name { font-weight: 600; color: var(--dark); font-size: 13px; }
        .rank-badge { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; font-size: 11px; font-weight: 800; }
        .rank-1 { background: #fef3c7; color: #92400e; }
        .rank-2 { background: #f1f5f9; color: #475569; }
        .rank-3 { background: #fef9c3; color: #713f12; }
        .rank-n { background: #f8fafc; color: var(--muted); }
        .badge-red { background: #fef2f2; color: var(--red); font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 20px; display: inline-block; }
        .badge-yellow { background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 20px; display: inline-block; }
        .badge-green { background: var(--green-light); color: var(--green-dark); font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 20px; display: inline-block; }
        .td-muted { color: var(--muted); }
        .empty-state { text-align: center; padding: 48px; color: var(--muted); }
    </style>
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
        <a href="{{ route('admin.lokasi') }}" class="nav-item"><i data-lucide="map-pin"></i> Lokasi Kerja</a>
        <a href="{{ route('admin.jadwal_mode') }}" class="nav-item"><i data-lucide="calendar-check"></i> Jadwal Mode Kerja</a>
        <a href="{{ route('admin.pengumuman') }}" class="nav-item"><i data-lucide="megaphone"></i> Pengumuman</a>
        <a href="{{ route('admin.departemen') }}" class="nav-item"><i data-lucide="layers"></i> Departemen</a>
        <a href="{{ route('admin.statistik') }}" class="nav-item active"><i data-lucide="bar-chart-2"></i> Statistik</a>
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
    <h1 class="page-title">Statistik Keterlambatan</h1>
    <p class="page-sub">Analisis keterlambatan karyawan per periode</p>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.statistik') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Bulan</label>
                    <select name="bulan" class="filter-select">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromDate(null, (int) $m, 1)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tahun</label>
                    <select name="tahun" class="filter-select">
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-filter">
                    <i data-lucide="search" style="width:14px;height:14px;display:inline;vertical-align:-2px;margin-right:4px;"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Tren Keterlambatan (6 Bulan)</span>
            </div>
            <div class="card-body">
                <canvas id="trenChart" height="200"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="card-title">Top 5 Paling Sering Terlambat</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Karyawan</th>
                        <th>Terlambat</th>
                        <th>Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($top5Terlambat as $i => $s)
                    <tr>
                        <td>
                            <span class="rank-badge {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-n')) }}">{{ $i + 1 }}</span>
                        </td>
                        <td>
                            <div class="user-cell">
                                <div class="user-av">{{ strtoupper(substr($s['user']->name, 0, 1)) }}</div>
                                <span class="user-name">{{ $s['user']->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge-red">{{ $s['total_terlambat'] }}x</span></td>
                        <td class="td-muted">{{ $s['rata_menit_terlambat'] }} mnt</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="empty-state">Tidak ada data keterlambatan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Detail Per Karyawan — {{ \Carbon\Carbon::createFromDate(null, (int) $bulan, 1)->translatedFormat('F') }} {{ $tahun }}</span>
            <span style="font-size:12px;color:var(--muted);background:#f8fafc;border:1px solid var(--border);border-radius:20px;padding:2px 10px;font-weight:600;">{{ $statistik->count() }} karyawan</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Karyawan</th>
                    <th>Hadir</th>
                    <th>Terlambat</th>
                    <th>Total Menit</th>
                    <th>Rata-rata</th>
                    <th>Alfa</th>
                    <th>Izin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statistik as $i => $s)
                <tr>
                    <td class="td-muted">{{ $i + 1 }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-av">{{ strtoupper(substr($s['user']->name, 0, 1)) }}</div>
                            <span class="user-name">{{ $s['user']->name }}</span>
                        </div>
                    </td>
                    <td><span class="badge-green">{{ $s['total_hadir'] }}</span></td>
                    <td>
                        @if($s['total_terlambat'] > 0)
                            <span class="badge-red">{{ $s['total_terlambat'] }}x</span>
                        @else
                            <span class="td-muted">—</span>
                        @endif
                    </td>
                    <td class="td-muted">{{ $s['total_menit_terlambat'] > 0 ? $s['total_menit_terlambat'].' mnt' : '—' }}</td>
                    <td class="td-muted">{{ $s['rata_menit_terlambat'] > 0 ? $s['rata_menit_terlambat'].' mnt' : '—' }}</td>
                    <td>
                        @if($s['total_alfa'] > 0)
                            <span class="badge-red">{{ $s['total_alfa'] }}</span>
                        @else
                            <span class="td-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($s['total_izin'] > 0)
                            <span class="badge-yellow">{{ $s['total_izin'] }}</span>
                        @else
                            <span class="td-muted">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="empty-state">Tidak ada data karyawan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script>
lucide.createIcons();
new Chart(document.getElementById('trenChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: @json($trenLabels),
        datasets: [{
            label: 'Keterlambatan',
            data: @json($trenData),
            backgroundColor: 'rgba(239,68,68,0.15)',
            borderColor: '#ef4444',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
</body>
</html>
