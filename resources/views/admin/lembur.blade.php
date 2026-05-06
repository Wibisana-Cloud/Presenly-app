<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lembur – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
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
        .filter-select, .filter-input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 9px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .filter-select { min-width: 120px; }
        .filter-input { min-width: 180px; }
        .filter-select:focus, .filter-input:focus { border-color: var(--green); background: #f0fdf4; }
        .filter-input::placeholder { color: #94a3b8; }
        .btn-filter { padding: 9px 18px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 8px rgba(34,197,94,0.25); }
        .btn-reset { padding: 9px 14px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-reset:hover { border-color: #fca5a5; color: #dc2626; background: #fef2f2; }
        .stats-mini { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
        .stat-mini-item { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 12px 18px; display: flex; align-items: center; gap: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
        .stat-mini-num { font-size: 20px; font-weight: 800; }
        .stat-mini-num.yellow { color: #92400e; }
        .stat-mini-num.green { color: var(--green-dark); }
        .stat-mini-label { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--muted); }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 11px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); background: #f8fafc; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }
        tbody td { padding: 11px 16px; font-size: 13px; }
        .user-cell { display: flex; align-items: center; gap: 8px; }
        .user-av { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, var(--green), #15803d); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: white; flex-shrink: 0; }
        .user-name { font-weight: 600; color: var(--dark); }
        .user-email { font-size: 11px; color: var(--muted); }
        .badge { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge.Pending   { background: #fef3c7; color: #92400e; }
        .badge.Disetujui { background: var(--green-light); color: var(--green-dark); }
        .badge.Ditolak   { background: #fef2f2; color: var(--red); }
        .td-muted { color: var(--muted); }
        .td-green { color: var(--green-dark); font-weight: 600; }
        .action-btn { padding: 5px 12px; border-radius: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s; }
        .btn-approve { background: var(--green-light); color: var(--green-dark); border: 1px solid var(--green-mid); }
        .btn-approve:hover { background: var(--green-mid); }
        .btn-reject { background: #fef2f2; color: var(--red); border: 1px solid #fecaca; }
        .btn-reject:hover { background: #fee2e2; }
        .pagination-wrap { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; }
        .pagination-wrap .pagination { display: flex; gap: 6px; list-style: none; }
        .pagination li a, .pagination li span { padding: 6px 12px; border-radius: 8px; font-size: 12px; text-decoration: none; background: #f8fafc; border: 1.5px solid var(--border); color: var(--text); transition: all 0.2s; }
        .pagination li a:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
        .pagination li.active span { background: var(--green); color: white; border-color: var(--green); font-weight: 700; }
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
        <a href="{{ route('admin.statistik') }}" class="nav-item"><i data-lucide="bar-chart-2"></i> Statistik</a>
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
    <h1 class="page-title">Kelola Lembur</h1>
    <p class="page-sub">Persetujuan pengajuan lembur karyawan</p>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid var(--green-mid);color:var(--green-dark);padding:10px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;font-weight:600;">
        {{ session('success') }}
    </div>
    @endif

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.lembur') }}">
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
                <div class="filter-group">
                    <label class="filter-label">Cari Nama</label>
                    <input type="text" name="search" class="filter-input" placeholder="Nama karyawan..." value="{{ $search }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-select">
                        <option value="">Semua</option>
                        <option value="Pending" {{ $status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ $status === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">
                    <i data-lucide="search" style="width:14px;height:14px;display:inline;vertical-align:-2px;margin-right:4px;"></i>Tampilkan
                </button>
                @if($search || $status)
                <a href="{{ route('admin.lembur') }}" class="btn-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="stats-mini">
        <div class="stat-mini-item">
            <div>
                <div class="stat-mini-num yellow">{{ $totalPending }}</div>
                <div class="stat-mini-label">Menunggu persetujuan</div>
            </div>
        </div>
        <div class="stat-mini-item">
            <div>
                <div class="stat-mini-num green">{{ $totalDisetujui }}</div>
                <div class="stat-mini-label">Disetujui bulan ini</div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Daftar Lembur</span>
            <span style="font-size:12px;color:var(--muted);background:#f8fafc;border:1px solid var(--border);border-radius:20px;padding:2px 10px;font-weight:600;">
                {{ $lemburans->total() }} data
            </span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Durasi</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lemburans as $i => $item)
                <tr>
                    <td class="td-muted">{{ $lemburans->firstItem() + $i }}</td>
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
                    <td class="td-green">{{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-' }}</td>
                    <td class="td-muted">{{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}</td>
                    <td class="td-muted">{{ $item->durasi_lembur ?? '-' }}</td>
                    <td class="td-muted" style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $item->keterangan ?? '-' }}
                    </td>
                    <td><span class="badge {{ $item->status }}">{{ $item->status }}</span></td>
                    <td>
                        @if($item->status === 'Pending')
                        <div style="display:flex;gap:6px;">
                            <form method="POST" action="{{ route('admin.lembur.approve', $item->id) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn btn-approve">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('admin.lembur.reject', $item->id) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn btn-reject">Tolak</button>
                            </form>
                        </div>
                        @else
                        <span class="td-muted" style="font-size:11px;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center;padding:48px;color:var(--muted);">Tidak ada data lembur</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($lemburans->hasPages())
        <div class="pagination-wrap">
            {{ $lemburans->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</main>

<script>lucide.createIcons();</script>
</body>
</html>
