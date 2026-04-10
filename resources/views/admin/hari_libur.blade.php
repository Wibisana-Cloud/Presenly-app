<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hari Libur – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 32px; }
        .page-header { margin-bottom: 28px; }
        .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; color: var(--dark); letter-spacing: -0.5px; display: flex; align-items: center; gap: 10px; }
        .page-sub { font-size: 13px; color: var(--muted); margin-top: 4px; }

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* CARDS */
        .grid-2 { display: grid; grid-template-columns: 1fr 1.6fr; gap: 20px; margin-bottom: 24px; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

        /* FORM */
        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: 12px; color: var(--muted); margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
        input[type="date"], input[type="text"], select {
            width: 100%; background: #f8fafc; border: 1.5px solid var(--border);
            border-radius: 8px; padding: 10px 12px; color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s;
        }
        input:focus, select:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
        input::placeholder { color: #94a3b8; }

        .btn { padding: 10px 20px; border-radius: 8px; border: none; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-green { background: var(--green); color: white; width: 100%; margin-top: 4px; }
        .btn-green:hover { background: var(--green-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,197,94,0.3); }
        .btn-sync { background: #eff6ff; color: var(--blue); border: 1.5px solid #bfdbfe; padding: 10px 20px; }
        .btn-sync:hover { background: #dbeafe; }
        .btn-red { background: #fef2f2; color: var(--red); border: 1px solid #fecaca; padding: 6px 12px; font-size: 12px; font-weight: 600; }
        .btn-red:hover { background: #fee2e2; }

        /* FILTER ROW */
        .filter-row { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .filter-row select { width: auto; }
        .filter-row .total { font-size: 12px; color: var(--muted); margin-left: auto; }

        /* SYNC ROW */
        .sync-row { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 14px 16px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; }
        .sync-info { flex: 1; font-size: 12px; color: var(--muted); }
        .sync-info strong { color: var(--blue); display: block; font-size: 13px; margin-bottom: 2px; font-weight: 700; }

        /* DIVIDER */
        .card-divider { margin: 24px 0 20px; padding-top: 20px; border-top: 1px solid var(--border); }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600; padding: 10px 14px; text-align: left; border-bottom: 1px solid var(--border); background: #f8fafc; }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--text); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf4; }
        .td-name { font-weight: 600; color: var(--dark); }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .badge.nasional { background: var(--green-light); color: var(--green-dark); border: 1px solid var(--green-mid); }
        .badge.manual   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

        /* STATS */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px; text-align: center; }
        .stat-num { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; }
        .stat-num.green  { color: var(--green-dark); }
        .stat-num.yellow { color: var(--yellow); }
        .stat-num.blue   { color: var(--blue); }
        .stat-label { font-size: 11px; color: var(--muted); margin-top: 2px; }

        .empty { text-align: center; padding: 40px; color: var(--muted); font-size: 13px; }
    </style>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">P</div>
        <span class="logo-text">Presenly</span>
        <span class="sidebar-badge">ADMIN</span>
    </div>

    <span class="nav-section">Menu</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item"><i data-lucide="layout-dashboard"></i> Dashboard</a>
    <a href="{{ route('admin.karyawan') }}" class="nav-item"><i data-lucide="users"></i> Karyawan</a>
    <a href="{{ route('admin.absensi') }}" class="nav-item"><i data-lucide="clipboard-list"></i> Semua Absensi</a>
    <a href="{{ route('admin.izin') }}" class="nav-item"><i data-lucide="file-clock"></i> Izin @if($izinPendingCount > 0)<span class="nav-badge">{{ $izinPendingCount }}</span>@endif</a>
    <a href="{{ route('admin.hari_libur') }}" class="nav-item active"><i data-lucide="calendar-off"></i> Hari Libur</a>
    <a href="{{ route('admin.lokasi') }}" class="nav-item"><i data-lucide="map-pin"></i> Lokasi Kerja</a>
        <a href="{{ route('admin.jadwal_mode') }}" class="nav-item"><i data-lucide="calendar-check"></i> Jadwal Mode Kerja</a>
    <span class="nav-section">Sistem</span>
    <a href="{{ route('admin.audit_log') }}" class="nav-item"><i data-lucide="shield-check"></i> Audit Log</a>

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

<!-- MAIN -->
<main class="main">
    <div class="page-header">
        <h1 class="page-title"><i data-lucide="calendar-off"></i> Hari Libur</h1>
        <p class="page-sub">Kelola hari libur nasional dan khusus perusahaan</p>
    </div>

    @if(session('success'))
        <div class="alert success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error"><i data-lucide="alert-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="grid-2">
        <!-- Form tambah manual -->
        <div class="card">
            <div class="card-title"><i data-lucide="plus-circle"></i> Tambah Hari Libur Manual</div>

            <form method="POST" action="{{ route('admin.hari_libur.store') }}">
                @csrf
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal') <div style="color:var(--red);font-size:11px;margin-top:4px">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Nama Hari Libur</label>
                    <input type="text" name="nama" placeholder="cth: Hari Jadi Kota" value="{{ old('nama') }}" required>
                    @error('nama') <div style="color:var(--red);font-size:11px;margin-top:4px">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-green">Tambahkan</button>
            </form>

            <div class="card-divider">
                <div class="card-title"><i data-lucide="refresh-cw"></i> Sinkronisasi API</div>
                <div class="sync-row" style="flex-direction:column;align-items:flex-start">
                    <div class="sync-info">
                        <strong>Hari Libur Nasional Indonesia</strong>
                        Ambil otomatis dari API harilibur.vercel.app
                    </div>
                    <form method="POST" action="{{ route('admin.hari_libur.sync') }}" style="display:flex;gap:10px;margin-top:10px;width:100%">
                        @csrf
                        <select name="tahun" style="flex:1">
                            @foreach($tahunList as $t)
                                <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sync">Sinkronisasi</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar hari libur -->
        <div class="card">
            <div class="filter-row">
                <div class="card-title" style="margin:0"><i data-lucide="calendar"></i> Daftar Hari Libur</div>
                <form method="GET" style="display:flex;gap:8px;margin-left:auto">
                    <select name="tahun" onchange="this.form.submit()">
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-num green">{{ $hariLibur->count() }}</div>
                    <div class="stat-label">Total</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num blue">{{ $hariLibur->where('tipe','nasional')->count() }}</div>
                    <div class="stat-label">Nasional</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num yellow">{{ $hariLibur->where('tipe','manual')->count() }}</div>
                    <div class="stat-label">Manual</div>
                </div>
            </div>

            @if($hariLibur->isEmpty())
                <div class="empty">
                    Belum ada data hari libur untuk tahun {{ $tahun }}.<br>
                    Klik <strong>Sinkronisasi</strong> untuk import otomatis!
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hariLibur as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                <td class="td-name">{{ $item->nama }}</td>
                                <td>
                                    <span class="badge {{ $item->tipe }}">
                                        @if($item->tipe === 'nasional')
                                            <i data-lucide="flag"></i> Nasional
                                        @else
                                            <i data-lucide="pencil"></i> Manual
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($item->is_manual)
                                    <form method="POST" action="{{ route('admin.hari_libur.destroy', $item->id) }}"
                                        onsubmit="return confirm('Hapus hari libur ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red">Hapus</button>
                                    </form>
                                    @else
                                    <span style="font-size:11px;color:var(--muted)">–</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</main>

<script>lucide.createIcons();</script>
</body>
</html>