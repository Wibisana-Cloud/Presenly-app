<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap {{ $user->name }} – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --gray: #64748b; --gray-light: #f8fafc; --white: #ffffff;
            --text: #1e293b; --border: #e2e8f0; --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --sidebar-w: 230px;
        }
        body { background: #eef4fb; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; min-height: 100vh; display: flex; }

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
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; }

        /* BACK */
        .back-link { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: var(--gray); text-decoration: none; margin-bottom: 20px; transition: color 0.2s; font-weight: 500; }
        .back-link:hover { color: var(--text); }
        .back-link svg { width: 14px; height: 14px; }

        /* PROFILE HEADER */
        .profile-header { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .profile-av { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--green-dark)); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: white; flex-shrink: 0; }
        .profile-name { font-size: 18px; font-weight: 800; color: var(--dark); letter-spacing: -0.3px; }
        .profile-email { font-size: 12px; color: var(--gray); margin-top: 2px; }

        /* FILTER */
        .filter-card { background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 16px 20px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .filter-row { display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-label { font-size: 11px; color: var(--gray); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
        .filter-select { background: var(--gray-light); border: 1.5px solid var(--border); border-radius: 9px; padding: 9px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; min-width: 130px; }
        .filter-select:focus { border-color: var(--green); background: #f0fdf4; }
        .btn-filter { padding: 9px 18px; background: var(--green); color: white; border: none; border-radius: 9px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .btn-filter:hover { background: var(--green-dark); }
        .btn-export { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; background: var(--gray-light); border: 1.5px solid var(--border); border-radius: 9px; color: var(--gray); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .btn-export:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
        .btn-export svg { width: 14px; height: 14px; }

        /* STATS */
        .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 16px 18px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .stat-card-label { font-size: 11px; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; margin-bottom: 6px; }
        .stat-card-num { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
        .stat-card-num.green  { color: var(--green-dark); }
        .stat-card-num.yellow { color: var(--yellow); }
        .stat-card-num.blue   { color: var(--blue); }
        .stat-card-num.gray   { color: var(--gray); }

        /* TABLE */
        .table-card { background: var(--white); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-size: 13px; font-weight: 700; color: var(--dark); text-transform: uppercase; letter-spacing: 0.5px; }
        .table-sub { font-size: 11px; color: var(--gray); background: var(--gray-light); border: 1px solid var(--border); padding: 2px 10px; border-radius: 20px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 10px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray); font-weight: 600; border-bottom: 1px solid var(--border); background: var(--gray-light); }
        tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: linear-gradient(to right, #f0fdf4, #f8fafc); }
        tbody td { padding: 11px 16px; font-size: 13px; color: var(--text); }
        .td-muted { color: var(--gray); }
        .td-green { color: var(--green-dark); font-weight: 600; }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .badge-hadir     { background: var(--green-light); color: var(--green-dark); }
        .badge-terlambat { background: #fef3c7; color: #92400e; }
        .badge-alfa      { background: #fef2f2; color: var(--red); }
        .badge-izin      { background: #dbeafe; color: #1d4ed8; }
        .badge-wfa       { background: #dbeafe; color: #1d4ed8; }
        .badge-wfo       { background: var(--gray-light); color: var(--gray); border: 1px solid var(--border); }

        .empty-cell { text-align: center; padding: 48px; color: var(--gray); font-size: 13px; }

        /* PAGINATION */
        .pagination-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); }
        .pagination-info { font-size: 12px; color: var(--gray); }
        .pagination-btns { display: flex; align-items: center; gap: 6px; }
        .page-btn { display: inline-flex; align-items: center; gap: 4px; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: 1.5px solid var(--border); background: var(--white); color: var(--text); }
        .page-btn:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
        .page-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
        .page-current { padding: 7px 12px; font-size: 12px; font-weight: 700; color: var(--green-dark); background: var(--green-light); border: 1.5px solid var(--green-mid); border-radius: 8px; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .stat-card, .table-card, .filter-card { animation: fadeUp 0.3s ease both; }
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
        <a href="{{ route('admin.karyawan') }}" class="nav-item active"><i data-lucide="users"></i> Karyawan</a>
        <a href="{{ route('admin.absensi') }}" class="nav-item"><i data-lucide="clipboard-list"></i> Semua Absensi</a>
        <a href="{{ route('admin.izin') }}" class="nav-item">
            <i data-lucide="file-clock"></i> Izin
            @if($izinPendingCount > 0)
                <span class="nav-badge">{{ $izinPendingCount }}</span>
            @endif
        </a>
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
            @csrf
            <button type="submit" class="logout-btn">Keluar</button>
        </form>
    </div>
</aside>

<main class="main">

    <a href="{{ route('admin.karyawan') }}" class="back-link">
        <i data-lucide="arrow-left"></i> Kembali ke Daftar Karyawan
    </a>

    <div class="profile-header">
        <div class="profile-av">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.karyawan.show', $user->id) }}" class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Bulan</label>
                <select name="bulan" class="filter-select">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" @selected($m == $bulan)>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Tahun</label>
                <select name="tahun" class="filter-select">
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" @selected($t == $tahun)>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-filter">Tampilkan</button>
            <a href="{{ route('admin.karyawan.export.csv', ['id' => $user->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="btn-export">
                <i data-lucide="download"></i> Export CSV
            </a>
        </form>
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-label">Total Hari Masuk</div>
            <div class="stat-card-num green">{{ $totalAbsensi }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Hadir Tepat Waktu</div>
            <div class="stat-card-num green">{{ $totalHadir }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Terlambat</div>
            <div class="stat-card-num yellow">{{ $totalTerlambat }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">WFA / WFO</div>
            <div class="stat-card-num blue" style="font-size: 20px;">{{ $totalWFA }} / {{ $totalWFO }}</div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <span class="table-title">
                Riwayat Absensi — {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
            </span>
            <span class="table-sub">{{ $totalAbsensi }} hari tercatat</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Durasi</th>
                    <th>Jarak</th>
                    <th>Mode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $row)
                <tr>
                    <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                    <td class="td-muted">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l') }}</td>
                    <td class="td-green">{{ $row->jam_masuk  ? \Carbon\Carbon::parse($row->jam_masuk)->format('H:i')  : '-' }}</td>
                    <td class="td-muted">{{ $row->jam_pulang ? \Carbon\Carbon::parse($row->jam_pulang)->format('H:i') : '-' }}</td>
                    <td class="td-muted">{{ $row->durasi_kerja ?? '-' }}</td>
                    <td class="td-muted">{{ $row->jarak_meter ? number_format($row->jarak_meter, 0, ',', '.') . ' m' : '-' }}</td>
                    <td>
                        @if($row->mode_kerja === 'WFA')
                            <span class="badge badge-wfa"><i data-lucide="laptop"></i> WFA</span>
                        @else
                            <span class="badge badge-wfo"><i data-lucide="building-2"></i> WFO</span>
                        @endif
                    </td>
                    <td>
                        @if($row->status === 'Hadir')
                            <span class="badge badge-hadir">Hadir</span>
                        @elseif($row->status === 'Terlambat')
                            <span class="badge badge-terlambat">Terlambat</span>
                        @elseif($row->status === 'Alfa')
                            <span class="badge badge-alfa">Alfa</span>
                        @else
                            <span class="badge badge-izin">{{ $row->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-cell">
                        <i data-lucide="inbox" style="width:24px;height:24px;display:block;margin:0 auto 8px;opacity:0.4;"></i>
                        Tidak ada data absensi di bulan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($absensi->hasPages())
        <div class="pagination-wrap">
            <span class="pagination-info">
                Menampilkan {{ $absensi->firstItem() }}–{{ $absensi->lastItem() }} dari {{ $absensi->total() }} data
            </span>
            <div class="pagination-btns">
                @if($absensi->onFirstPage())
                    <span class="page-btn disabled"><i data-lucide="chevron-left"></i> Sebelumnya</span>
                @else
                    <a href="{{ $absensi->previousPageUrl() }}" class="page-btn"><i data-lucide="chevron-left"></i> Sebelumnya</a>
                @endif
                <span class="page-current">{{ $absensi->currentPage() }} / {{ $absensi->lastPage() }}</span>
                @if($absensi->hasMorePages())
                    <a href="{{ $absensi->nextPageUrl() }}" class="page-btn">Selanjutnya <i data-lucide="chevron-right"></i></a>
                @else
                    <span class="page-btn disabled">Selanjutnya <i data-lucide="chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</main>

<script>lucide.createIcons();</script>
</body>
</html>
