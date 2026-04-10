<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Absensi – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-deeper: #15803d;
            --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --card: #ffffff; --border: #e2e8f0;
            --muted: #64748b; --white: #ffffff; --text: #1e293b;
            --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --sidebar-w: 230px; --bg: #eef4fb;
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
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; position: relative; z-index: 1; }
        .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; color: var(--dark); }
        .page-sub { font-size: 12px; color: var(--muted); margin-bottom: 24px; }

        /* Filter */
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
        .filter-divider { width: 1px; background: var(--border); align-self: stretch; margin: 0 4px; }
        .filter-date-input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 9px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; min-width: 150px; }
        .filter-date-input:focus { border-color: var(--green); background: #f0fdf4; }
        .filter-section-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.7px; color: var(--muted); font-weight: 700; padding: 0 2px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .filter-section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .date-range-badge { display: inline-flex; align-items: center; gap: 5px; background: #dcfce7; border: 1px solid var(--green-mid); color: var(--green-dark); font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .btn-export { padding: 9px 16px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-export:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }

        /* Stats Mini */
        .stats-mini { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
        .stat-mini-item { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 12px 18px; display: flex; align-items: center; gap: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
        .stat-mini-num { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; }
        .stat-mini-num.green { color: var(--green-dark); }
        .stat-mini-num.blue  { color: var(--blue); }
        .stat-mini-label { font-size: 11px; color: var(--muted); margin-top: 1px; display: flex; align-items: center; gap: 4px; }

        /* Table */
        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--muted); }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 11px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); background: #f8fafc; }
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

        /* Status badge */
        .badge { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge.Hadir,     .badge.hadir     { background: var(--green-light); color: var(--green-dark); }
        .badge.Terlambat, .badge.terlambat { background: #fef3c7; color: #92400e; }
        .badge.Alfa,      .badge.alfa      { background: #fef2f2; color: var(--red); }
        .badge.Izin,      .badge.izin      { background: #dbeafe; color: #1d4ed8; }

        /* Mode badge */
        .mode-badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .mode-badge.wfo { background: var(--green-light); color: var(--green-dark); border: 1px solid var(--green-mid); }
        .mode-badge.wfa { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }

        /* Row highlight WFA */
        tbody tr.row-wfa { background: #f0f9ff; }
        tbody tr.row-wfa:hover { background: #e0f2fe; }

        /* Pagination */
        .pagination-wrap { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; }
        .pagination-wrap .pagination { display: flex; gap: 6px; list-style: none; }
        .pagination li a, .pagination li span { padding: 6px 12px; border-radius: 8px; font-size: 12px; text-decoration: none; background: #f8fafc; border: 1.5px solid var(--border); color: var(--text); transition: all 0.2s; }
        .pagination li a:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
        .pagination li.active span { background: var(--green); color: white; border-color: var(--green); font-weight: 700; }

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
        <a href="{{ route('admin.absensi') }}" class="nav-item active"><i data-lucide="clipboard-list"></i> Semua Absensi</a>
        <a href="{{ route('admin.izin') }}" class="nav-item"><i data-lucide="file-clock"></i> Izin @if($izinPendingCount > 0)<span class="nav-badge">{{ $izinPendingCount }}</span>@endif</a>
        <a href="{{ route('admin.hari_libur') }}" class="nav-item"><i data-lucide="calendar-off"></i> Hari Libur</a>
        <a href="{{ route('admin.lokasi') }}" class="nav-item"><i data-lucide="map-pin"></i> Lokasi Kerja</a>
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
    <h1 class="page-title">Semua Absensi</h1>
    <p class="page-sub">Rekap kehadiran seluruh karyawan</p>

    <!-- Filter -->
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.absensi') }}" id="filter-form">
            <div class="filter-section-label">Filter Bulan / Tahun</div>
            <div class="filter-row" style="margin-bottom: 14px;">
                <div class="filter-group">
                    <label class="filter-label">Bulan</label>
                    <select name="bulan" class="filter-select" {{ $useDateRange ? 'disabled' : '' }}>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tahun</label>
                    <select name="tahun" class="filter-select" {{ $useDateRange ? 'disabled' : '' }}>
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-divider"></div>
                <div class="filter-group">
                    <label class="filter-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" class="filter-date-input" value="{{ $tanggalDari }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" class="filter-date-input" value="{{ $tanggalSampai }}">
                </div>
            </div>
            <div class="filter-section-label">Filter Lainnya</div>
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Cari Nama</label>
                    <input type="text" name="search" class="filter-input" placeholder="Nama karyawan..." value="{{ $search }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Mode Kerja</label>
                    <select name="mode" class="filter-select">
                        <option value="">Semua</option>
                        <option value="WFO" {{ request('mode') == 'WFO' ? 'selected' : '' }}>WFO</option>
                        <option value="WFA" {{ request('mode') == 'WFA' ? 'selected' : '' }}>WFA</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter"><i data-lucide="search" style="width:14px;height:14px;display:inline;vertical-align:-2px;margin-right:4px;"></i>Tampilkan</button>
                @if($useDateRange || $search || request('mode'))
                <a href="{{ route('admin.absensi') }}" class="btn-reset">Reset</a>
                @endif
                <a href="{{ route('admin.export.csv', ['bulan' => $bulan, 'tahun' => $tahun, 'tanggal_dari' => $tanggalDari, 'tanggal_sampai' => $tanggalSampai]) }}" class="btn-export">
                    <i data-lucide="download"></i> Export CSV
                </a>
            </div>
        </form>
    </div>

    <!-- Stats Mini -->
    <div class="stats-mini">
        <div class="stat-mini-item">
            <div>
                <div class="stat-mini-num green">{{ $totalWFO ?? 0 }}</div>
                <div class="stat-mini-label"><i data-lucide="building-2"></i> WFO bulan ini</div>
            </div>
        </div>
        <div class="stat-mini-item">
            <div>
                <div class="stat-mini-num blue">{{ $totalWFA ?? 0 }}</div>
                <div class="stat-mini-label"><i data-lucide="laptop"></i> WFA bulan ini</div>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="table-card">
        <div class="table-header">
            @if($useDateRange)
                <span class="table-title">
                    <span class="date-range-badge"><i data-lucide="calendar-range" style="width:12px;height:12px;"></i>{{ \Carbon\Carbon::parse($tanggalDari)->translatedFormat('d M Y') }} – {{ \Carbon\Carbon::parse($tanggalSampai)->translatedFormat('d M Y') }}</span>
                </span>
            @else
                <span class="table-title">{{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F') }} {{ $tahun }}</span>
            @endif
            <span style="font-size:12px; color: var(--muted); background:#f8fafc; border:1px solid var(--border); border-radius:20px; padding:2px 10px; font-weight:600;">{{ $absensi->total() }} data</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Durasi</th>
                    <th>Jarak</th>
                    <th>Mode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $i => $item)
                <tr class="{{ ($item->mode_kerja ?? 'WFO') === 'WFA' ? 'row-wfa' : '' }}">
                    <td class="td-muted">{{ $absensi->firstItem() + $i }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-av">{{ strtoupper(substr($item->user->name ?? 'K', 0, 1)) }}</div>
                            <div>
                                <div class="user-name">{{ $item->user->name ?? '-' }}</div>
                                <div class="user-email">{{ $item->user->email ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="td-muted">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                    <td class="td-green">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
                    <td class="td-muted">{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
                    <td class="td-muted">{{ $item->durasi_kerja ?? '-' }}</td>
                    <td class="td-muted">{{ $item->jarak_meter ? number_format($item->jarak_meter, 0) . ' m' : '-' }}</td>
                    <td>
                        @if(($item->mode_kerja ?? 'WFO') === 'WFA')
                            <span class="mode-badge wfa"><i data-lucide="laptop"></i> WFA</span>
                        @else
                            <span class="mode-badge wfo"><i data-lucide="building-2"></i> WFO</span>
                        @endif
                    </td>
                    <td><span class="badge {{ $item->status }}">{{ $item->status ?? '-' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center; padding:48px; color: var(--muted);"><i data-lucide="inbox"></i> Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($absensi->hasPages())
        <div class="pagination-wrap">
            {{ $absensi->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</main>

<script>
lucide.createIcons();

// Mutual exclusion: date range disables bulan/tahun selects
const dari = document.querySelector('[name="tanggal_dari"]');
const sampai = document.querySelector('[name="tanggal_sampai"]');
const bulanSel = document.querySelector('[name="bulan"]');
const tahunSel = document.querySelector('[name="tahun"]');

function syncDateRangeState() {
    const hasRange = dari.value && sampai.value;
    bulanSel.disabled = hasRange;
    tahunSel.disabled = hasRange;
    bulanSel.style.opacity = hasRange ? '0.4' : '1';
    tahunSel.style.opacity = hasRange ? '0.4' : '1';
}

dari.addEventListener('change', syncDateRangeState);
sampai.addEventListener('change', syncDateRangeState);
syncDateRangeState();
</script>
</body>
</html>