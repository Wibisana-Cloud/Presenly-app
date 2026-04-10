@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Izin – Admin Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
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

        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; min-height: 100vh; display: flex; }

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
        main { margin-left: var(--sidebar-w); flex: 1; padding: 32px 28px 60px; position: relative; z-index: 1; }

        .page-header { margin-bottom: 24px; animation: fadeUp 0.5s ease both; }
        .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; color: var(--dark); letter-spacing: -0.5px; }
        .page-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 500; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* STATS ROW */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; animation: fadeUp 0.5s 0.05s ease both; }
        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); text-decoration: none; color: inherit; transition: all 0.2s; cursor: pointer; }
        .stat-card:hover { border-color: var(--green-mid); box-shadow: 0 4px 12px rgba(0,0,0,0.08); transform: translateY(-1px); }
        .stat-icon { font-size: 24px; }
        .stat-num { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; }
        .stat-num.yellow { color: var(--yellow); }
        .stat-num.green  { color: var(--green-dark); }
        .stat-num.red    { color: var(--red); }
        .stat-label { font-size: 12px; color: var(--muted); margin-top: 1px; }

        /* FILTER */
        .filter-bar { display: flex; gap: 10px; margin-bottom: 16px; animation: fadeUp 0.5s 0.1s ease both; flex-wrap: wrap; }
        .filter-select { padding: 8px 12px; background: var(--white); border: 1.5px solid var(--border); border-radius: 8px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; cursor: pointer; outline: none; transition: all 0.2s; }
        .filter-select:focus { border-color: var(--green); background: #f0fdf4; }
        .filter-btn { padding: 8px 18px; background: var(--green); color: white; border: none; border-radius: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .filter-btn:hover { background: var(--green-dark); }

        /* TABLE CARD */
        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; animation: fadeUp 0.5s 0.15s ease both; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-card-header { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.8px; display: flex; align-items: center; gap: 8px; }

        table { width: 100%; border-collapse: collapse; }
        th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 1px solid var(--border); white-space: nowrap; background: #f8fafc; }
        td { padding: 14px 16px; font-size: 13px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf4; }

        .td-name { font-weight: 600; color: var(--dark); }
        .td-sub  { font-size: 11px; color: var(--muted); margin-top: 2px; }

        .jenis-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; background: #dbeafe; border: 1px solid #bfdbfe; color: #1d4ed8; }

        .status-badge { display: inline-block; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 100px; }
        .status-badge.Pending   { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; }
        .status-badge.Disetujui { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .status-badge.Ditolak   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* ACTION BUTTONS */
        .action-wrap { display: flex; gap: 6px; flex-direction: column; }
        .approve-btn, .reject-btn { padding: 6px 12px; border-radius: 7px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; }
        .approve-btn { background: var(--green); border: 1px solid var(--green-dark); color: white; }
        .approve-btn:hover { background: var(--green-dark); }
        .reject-btn  { background: var(--red); border: 1px solid #dc2626; color: white; }
        .reject-btn:hover  { background: #dc2626; }

        /* PROCESSED / ARSIP */
        .arsip-badge { display: inline-block; font-size: 11px; font-weight: 600; padding: 2px 9px; border-radius: 100px; }
        .arsip-badge.Disetujui { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .arsip-badge.Ditolak   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }
        .arsip-catatan { font-size: 11px; color: var(--muted); margin-top: 4px; line-height: 1.4; max-width: 150px; }

        /* MODAL */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.35); backdrop-filter: blur(3px); z-index: 200; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal { background: var(--white); border: 1px solid var(--border); border-radius: 20px; padding: 28px; width: 100%; max-width: 400px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); animation: fadeUp 0.3s ease both; }
        .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px; font-weight: 800; color: var(--dark); margin-bottom: 6px; }
        .modal-sub { font-size: 13px; color: var(--muted); margin-bottom: 18px; }
        .modal-input { width: 100%; padding: 10px 14px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; outline: none; resize: vertical; margin-bottom: 14px; transition: all 0.2s; }
        .modal-input:focus { border-color: var(--red); background: #fef2f2; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        .modal-input::placeholder { color: #94a3b8; }
        .modal-actions { display: flex; gap: 10px; }
        .modal-confirm { flex: 1; padding: 11px; background: var(--red); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .modal-confirm:hover { background: #dc2626; }
        .modal-cancel { padding: 11px 18px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; cursor: pointer; transition: all 0.2s; }
        .modal-cancel:hover { color: var(--text); border-color: #94a3b8; }

        /* PAGINATION */
        .pagination-wrap { padding: 16px 22px; border-top: 1px solid var(--border); }
        .pagination-wrap .pagination { display: flex; gap: 6px; list-style: none; }
        .pagination-wrap .page-link { padding: 6px 12px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 7px; color: var(--text); text-decoration: none; font-size: 13px; transition: all 0.2s; }
        .pagination-wrap .page-link:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
        .pagination-wrap .page-item.active .page-link { background: var(--green); color: white; border-color: var(--green); font-weight: 700; }

        .empty-state { padding: 48px; text-align: center; color: var(--muted); }
        .empty-state .icon { font-size: 36px; margin-bottom: 10px; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i data-lucide="layout-dashboard"></i> Dashboard</a>
        <a href="{{ route('admin.karyawan') }}" class="nav-item"><i data-lucide="users"></i> Karyawan</a>
        <a href="{{ route('admin.absensi') }}" class="nav-item"><i data-lucide="clipboard-list"></i> Semua Absensi</a>
        <a href="{{ route('admin.izin') }}" class="nav-item active"><i data-lucide="file-clock"></i> Izin @if($izinPendingCount > 0)<span class="nav-badge">{{ $izinPendingCount }}</span>@endif</a>
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

<main>
    <div class="page-header">
        <h1 class="page-title">Kelola Pengajuan Izin</h1>
        <p class="page-sub">Review dan proses pengajuan izin karyawan</p>
    </div>

    @if(session('success'))
        <div class="alert success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error"><i data-lucide="alert-circle"></i> {{ session('error') }}</div>
    @endif

    <!-- Stats -->
    <div class="stats-row">
        <a href="{{ route('admin.izin', ['status' => 'Pending']) }}" class="stat-card">
            <span class="stat-icon"><i data-lucide="clock"></i></span>
            <div>
                <div class="stat-num yellow">{{ $totalPending }}</div>
                <div class="stat-label">Menunggu Review</div>
            </div>
        </a>
        <a href="{{ route('admin.izin', ['status' => 'Disetujui']) }}" class="stat-card">
            <span class="stat-icon"><i data-lucide="check-circle"></i></span>
            <div>
                <div class="stat-num green">{{ $totalDisetujui }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
        </a>
        <a href="{{ route('admin.izin', ['status' => 'Ditolak']) }}" class="stat-card">
            <span class="stat-icon"><i data-lucide="x-circle"></i></span>
            <div>
                <div class="stat-num red">{{ $totalDitolak }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </a>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('admin.izin') }}" class="filter-bar">
        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="Pending"   {{ request('status') == 'Pending'   ? 'selected' : '' }}>Pending</option>
            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="Ditolak"   {{ request('status') == 'Ditolak'   ? 'selected' : '' }}>Ditolak</option>
        </select>
        <select name="jenis" class="filter-select">
            <option value="">Semua Jenis</option>
            <option value="Sakit"     {{ request('jenis') == 'Sakit'     ? 'selected' : '' }}>Sakit</option>
            <option value="Cuti"      {{ request('jenis') == 'Cuti'      ? 'selected' : '' }}>Cuti</option>
            <option value="Keperluan" {{ request('jenis') == 'Keperluan' ? 'selected' : '' }}>Keperluan</option>
        </select>
        <button type="submit" class="filter-btn">Filter</button>
    </form>

    <!-- Table -->
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title"><i data-lucide="clipboard-list"></i> Daftar Pengajuan Izin</span>
            <span style="font-size:12px;color:var(--muted);background:#f8fafc;border:1px solid var(--border);border-radius:20px;padding:2px 10px;font-weight:600;">{{ $izins->total() }} total</span>
        </div>

        @if($izins->isEmpty())
            <div class="empty-state">
                <div class="icon"><i data-lucide="inbox"></i></div>
                <p>Tidak ada pengajuan izin ditemukan.</p>
            </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($izins as $izin)
                <tr>
                    <td>
                        <div class="td-name">{{ $izin->user->nama_karyawan ?? $izin->user->name }}</div>
                        <div class="td-sub">Diajukan {{ $izin->created_at->diffForHumans() }}</div>
                    </td>
                    <td>
                        <span class="jenis-badge">
                            @if($izin->jenis_izin == 'Sakit') <i data-lucide="thermometer"></i>
                            @elseif($izin->jenis_izin == 'Cuti') <i data-lucide="umbrella"></i>
                            @else <i data-lucide="briefcase"></i>
                            @endif
                            {{ $izin->jenis_izin }}
                        </span>
                    </td>
                    <td>
                        <div>{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M Y') }}</div>
                        @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                            <div class="td-sub">s/d {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}</div>
                            <div class="td-sub" style="color:var(--green-dark);">{{ $izin->durasi }} hari</div>
                        @endif
                    </td>
                    <td style="max-width:180px;">
                        <div style="font-size:13px;line-height:1.4;">{{ Str::limit($izin->keterangan, 60) }}</div>
                        @if($izin->lampiran)
                            <a href="{{ Storage::url($izin->lampiran) }}" target="_blank"
                               style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;color:#1d4ed8;text-decoration:none;margin-top:4px;padding:2px 8px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:5px;">
                                <i data-lucide="paperclip" style="width:11px;height:11px;"></i> Lampiran
                            </a>
                        @endif
                        @if($izin->catatan_admin)
                            <div class="td-sub" style="margin-top:4px;"><i data-lucide="message-circle"></i> {{ Str::limit($izin->catatan_admin, 40) }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $izin->status }}">{{ $izin->status }}</span>
                        @if($izin->diproses_at)
                            <div class="td-sub" style="margin-top:4px;">{{ $izin->diproses_at->format('d M H:i') }}</div>
                        @endif
                    </td>
                    <td>
                        @if($izin->status == 'Pending')
                        <div class="action-wrap">
                            <form method="POST" action="{{ route('admin.izin.approve', $izin->id) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="catatan_admin" value="Pengajuan disetujui.">
                                <button type="submit" class="approve-btn" onclick="return confirm('Setujui izin ini?')">
                                    <i data-lucide="check"></i> Setujui
                                </button>
                            </form>
                            <button class="reject-btn" onclick="openRejectModal({{ $izin->id }}, '{{ addslashes($izin->user->nama_karyawan ?? $izin->user->name) }}')">
                                <i data-lucide="x"></i> Tolak
                            </button>
                        </div>
                        @else
                        <div>
                            <span class="arsip-badge {{ $izin->status }}">
                                @if($izin->status == 'Disetujui') <i data-lucide="check" style="width:10px;height:10px;"></i> Disetujui
                                @else <i data-lucide="x" style="width:10px;height:10px;"></i> Ditolak
                                @endif
                            </span>
                            @if($izin->diproses_at)
                                <div class="arsip-catatan">{{ $izin->diproses_at->format('d M Y, H:i') }}</div>
                            @endif
                            @if($izin->catatan_admin)
                                <div class="arsip-catatan" style="font-style:italic;">"{{ Str::limit($izin->catatan_admin, 50) }}"</div>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($izins->hasPages())
        <div class="pagination-wrap">
            {{ $izins->appends(request()->query())->links() }}
        </div>
        @endif
        @endif
    </div>
</main>

<!-- Reject Modal -->
<div class="modal-overlay" id="rejectModal">
    <div class="modal">
        <div class="modal-title">Tolak Pengajuan Izin</div>
        <div class="modal-sub" id="rejectModalSub">Berikan alasan penolakan</div>
        <form method="POST" id="rejectForm">
            @csrf @method('PATCH')
            <textarea name="catatan_admin" class="modal-input" rows="3"
                      placeholder="Tuliskan alasan penolakan..." required></textarea>
            <div class="modal-actions">
                <button type="button" class="modal-cancel" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="modal-confirm">Tolak Izin</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id, name) {
        document.getElementById('rejectModalSub').textContent = 'Alasan penolakan izin ' + name;
        document.getElementById('rejectForm').action = '/admin/izin/' + id + '/reject';
        document.getElementById('rejectModal').classList.add('open');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('open');
    }
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
</script>
<script>lucide.createIcons();</script>
</body>
</html>