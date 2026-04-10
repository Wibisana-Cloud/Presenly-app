<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log – Presenly Admin</title>
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
        .page-title { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; color: var(--dark); }
        .page-sub { font-size: 12px; color: var(--gray); margin-bottom: 24px; }

        /* FILTER */
        .filter-bar { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
        .filter-input { padding: 8px 12px; background: var(--white); border: 1.5px solid var(--border); border-radius: 8px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .filter-input:focus { border-color: var(--green); background: #f0fdf4; }
        .filter-btn { padding: 8px 18px; background: var(--green); color: white; border: none; border-radius: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .filter-btn:hover { background: var(--green-dark); }

        /* TABLE */
        .table-card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.3s ease both; }
        .table-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-size: 13px; font-weight: 700; color: var(--dark); text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; }
        .table-count { font-size: 11px; color: var(--gray); background: var(--gray-light); border: 1px solid var(--border); border-radius: 20px; padding: 2px 10px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 10px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray); font-weight: 600; border-bottom: 1px solid var(--border); background: var(--gray-light); white-space: nowrap; }
        tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: linear-gradient(to right, #f0fdf4, #f8fafc); }
        tbody td { padding: 12px 16px; font-size: 13px; color: var(--text); vertical-align: top; }
        .td-muted { color: var(--gray); font-size: 12px; }

        /* AKSI BADGE */
        .aksi-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; white-space: nowrap; }
        .aksi-tambah  { background: var(--green-light); color: var(--green-dark); }
        .aksi-edit    { background: #fef3c7; color: #92400e; }
        .aksi-hapus   { background: #fef2f2; color: var(--red); }
        .aksi-setujui { background: var(--green-light); color: var(--green-dark); }
        .aksi-tolak   { background: #fef2f2; color: var(--red); }
        .aksi-lokasi  { background: #ede9fe; color: #7c3aed; }
        .aksi-default { background: var(--gray-light); color: var(--gray); }

        /* PAGINATION */
        .pagination-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); }
        .pagination-info { font-size: 12px; color: var(--gray); }
        .pagination-btns { display: flex; align-items: center; gap: 6px; }
        .page-btn { display: inline-flex; align-items: center; gap: 4px; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: 1.5px solid var(--border); background: var(--white); color: var(--text); }
        .page-btn:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
        .page-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
        .page-current { padding: 7px 12px; font-size: 12px; font-weight: 700; color: var(--green-dark); background: var(--green-light); border: 1.5px solid var(--green-mid); border-radius: 8px; }

        .empty-cell { text-align: center; padding: 48px; color: var(--gray); font-size: 13px; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
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
        <a href="{{ route('admin.izin') }}" class="nav-item">
            <i data-lucide="file-clock"></i> Izin
            @if($izinPendingCount > 0)<span class="nav-badge">{{ $izinPendingCount }}</span>@endif
        </a>
        <a href="{{ route('admin.hari_libur') }}" class="nav-item"><i data-lucide="calendar-off"></i> Hari Libur</a>
        <a href="{{ route('admin.lokasi') }}" class="nav-item"><i data-lucide="map-pin"></i> Lokasi Kerja</a>
        <a href="{{ route('admin.jadwal_mode') }}" class="nav-item"><i data-lucide="calendar-check"></i> Jadwal Mode Kerja</a>
        <div class="nav-label">Sistem</div>
        <a href="{{ route('admin.audit_log') }}" class="nav-item active"><i data-lucide="shield-check"></i> Audit Log</a>
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
    <h1 class="page-title">Audit Log</h1>
    <p class="page-sub">Rekam jejak semua aktivitas admin dalam sistem</p>

    <form method="GET" action="{{ route('admin.audit_log') }}" class="filter-bar">
        <input type="text" name="search" class="filter-input" placeholder="Cari nama admin..."
               value="{{ $search }}" style="min-width: 200px;">
        <select name="aksi" class="filter-input">
            <option value="">Semua Aksi</option>
            @foreach($aksiList as $item)
                <option value="{{ $item }}" {{ $aksi === $item ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        <button type="submit" class="filter-btn">Filter</button>
        @if($search || $aksi)
            <a href="{{ route('admin.audit_log') }}" class="filter-btn" style="background:var(--gray-light);color:var(--gray);border:1.5px solid var(--border);text-decoration:none;">Reset</a>
        @endif
    </form>

    <div class="table-card">
        <div class="table-header">
            <span class="table-title"><i data-lucide="shield-check"></i> Log Aktivitas</span>
            <span class="table-count">{{ $logs->total() }} entri</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="white-space: nowrap;">
                        <div style="font-weight: 600; color: var(--dark);">{{ $log->created_at->format('d/m/Y') }}</div>
                        <div class="td-muted">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $log->user->name ?? '—' }}</div>
                        <div class="td-muted">{{ $log->user->email ?? '' }}</div>
                    </td>
                    <td>
                        @php
                            $aksiClass = match(true) {
                                str_starts_with($log->aksi, 'Tambah') => 'aksi-tambah',
                                str_starts_with($log->aksi, 'Edit')   => 'aksi-edit',
                                str_starts_with($log->aksi, 'Hapus')  => 'aksi-hapus',
                                str_starts_with($log->aksi, 'Setujui') => 'aksi-setujui',
                                str_starts_with($log->aksi, 'Tolak')  => 'aksi-tolak',
                                str_starts_with($log->aksi, 'Update') => 'aksi-lokasi',
                                default => 'aksi-default',
                            };
                        @endphp
                        <span class="aksi-badge {{ $aksiClass }}">{{ $log->aksi }}</span>
                    </td>
                    <td style="color: var(--gray); max-width: 360px; line-height: 1.5;">
                        {{ $log->deskripsi }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-cell">
                        <i data-lucide="inbox" style="width:24px;height:24px;display:block;margin:0 auto 8px;opacity:0.4;"></i>
                        Belum ada aktivitas yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
        <div class="pagination-wrap">
            <span class="pagination-info">
                Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} entri
            </span>
            <div class="pagination-btns">
                @if($logs->onFirstPage())
                    <span class="page-btn disabled"><i data-lucide="chevron-left"></i> Sebelumnya</span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="page-btn"><i data-lucide="chevron-left"></i> Sebelumnya</a>
                @endif
                <span class="page-current">{{ $logs->currentPage() }} / {{ $logs->lastPage() }}</span>
                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="page-btn">Selanjutnya <i data-lucide="chevron-right"></i></a>
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
