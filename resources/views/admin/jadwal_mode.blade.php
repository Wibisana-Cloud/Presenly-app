<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mode Kerja – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-deeper: #15803d;
            --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --card: #ffffff; --border: #e2e8f0;
            --muted: #64748b; --white: #ffffff; --text: #1e293b;
            --red: #ef4444; --blue: #3b82f6; --sidebar-w: 230px; --bg: #eef4fb;
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
        main { margin-left: var(--sidebar-w); flex: 1; padding: 32px 28px 60px; }
        .page-header { margin-bottom: 24px; animation: fadeUp 0.4s ease both; }
        .page-title { font-size: 24px; font-weight: 800; letter-spacing: -0.5px; color: var(--dark); }
        .page-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* LAYOUT */
        .layout { display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start; }

        /* FORM CARD */
        .form-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s ease both; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
        .card-header-title { font-size: 13px; font-weight: 700; color: var(--dark); }
        .card-body { padding: 20px; }

        /* INFO BOX */
        .info-box { display: flex; align-items: flex-start; gap: 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 12px 14px; margin-bottom: 18px; }
        .info-box [data-lucide] { width: 14px; height: 14px; flex-shrink: 0; color: var(--blue); margin-top: 2px; }
        .info-box-text { flex: 1; font-size: 12px; color: #1d4ed8; line-height: 1.6; }

        /* FIELDS */
        .field { margin-bottom: 16px; }
        .field label { display: block; font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; margin-bottom: 6px; }
        .field input, .field select, .field textarea { width: 100%; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
        .field-hint { font-size: 11px; color: var(--muted); font-weight: 400; margin-left: 4px; }
        .field-error { font-size: 11px; color: var(--red); margin-top: 4px; display: block; }

        /* MODE SELECTOR */
        .mode-options { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .mode-option { position: relative; }
        .mode-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .mode-option label { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 16px 10px; border: 2px solid var(--border); border-radius: 12px; cursor: pointer; transition: all 0.2s; background: #f8fafc; }
        .mode-option label [data-lucide] { width: 22px; height: 22px; color: var(--muted); transition: color 0.2s; }
        .mode-option input[type="radio"]:checked + label.wfo { border-color: var(--green); background: var(--green-light); }
        .mode-option input[type="radio"]:checked + label.wfo [data-lucide] { color: var(--green-dark); }
        .mode-option input[type="radio"]:checked + label.wfa { border-color: var(--blue); background: #eff6ff; }
        .mode-option input[type="radio"]:checked + label.wfa [data-lucide] { color: #1d4ed8; }
        .mode-name { font-size: 13px; font-weight: 700; color: var(--dark); }
        .mode-option input[type="radio"]:checked + label.wfo .mode-name { color: var(--green-dark); }
        .mode-option input[type="radio"]:checked + label.wfa .mode-name { color: #1d4ed8; }
        .mode-desc { font-size: 10px; color: var(--muted); text-align: center; line-height: 1.4; }

        .btn-save { width: 100%; padding: 11px; background: var(--green); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 4px; }
        .btn-save:hover { background: var(--green-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,197,94,0.25); }

        /* TABLE CARD */
        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s 0.05s ease both; }
        .count-chip { font-size: 12px; color: var(--muted); background: #f8fafc; border: 1px solid var(--border); border-radius: 20px; padding: 2px 10px; font-weight: 600; }

        table { width: 100%; border-collapse: collapse; }
        th { padding: 11px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 1px solid var(--border); background: #f8fafc; white-space: nowrap; }
        td { padding: 13px 16px; font-size: 13px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf4; }

        .td-date { font-weight: 600; color: var(--dark); white-space: nowrap; }
        .td-sub { font-size: 11px; color: var(--muted); margin-top: 2px; }

        .mode-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; white-space: nowrap; }
        .mode-badge.WFO { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .mode-badge.WFA { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }
        .mode-badge [data-lucide] { width: 11px; height: 11px; }

        .today-badge { font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 4px; background: #fef3c7; border: 1px solid #fde68a; color: #92400e; margin-left: 6px; vertical-align: middle; }

        .btn-delete { padding: 6px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 7px; color: var(--red); font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; }
        .btn-delete:hover { background: #fee2e2; }
        .btn-delete [data-lucide] { width: 12px; height: 12px; }

        .empty-state { padding: 56px 24px; text-align: center; color: var(--muted); }
        .empty-state-icon { width: 48px; height: 48px; background: #f1f5f9; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
        .empty-state-icon [data-lucide] { width: 24px; height: 24px; color: #94a3b8; }
        .empty-state p { font-size: 13px; line-height: 1.6; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
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
        <a href="{{ route('admin.jadwal_mode') }}" class="nav-item active"><i data-lucide="calendar-check"></i> Jadwal Mode Kerja</a>
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

<main>
    <div class="page-header">
        <h1 class="page-title">Jadwal Mode Kerja</h1>
        <p class="page-sub">Tentukan tanggal WFO atau WFA untuk seluruh karyawan</p>
    </div>

    @if(session('success'))
        <div class="alert success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error"><i data-lucide="alert-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="layout">

        {{-- Form Tambah --}}
        <div class="form-card">
            <div class="card-header">
                <i data-lucide="plus-circle" style="width:15px;height:15px;color:var(--green-dark);"></i>
                <span class="card-header-title">Tambah Jadwal</span>
            </div>
            <div class="card-body">
                <div class="info-box">
                    <i data-lucide="info"></i>
                    <span class="info-box-text">
                        Default semua hari adalah <strong>WFO</strong>. Tambahkan jadwal hanya untuk hari yang berbeda dari default.
                    </span>
                </div>

                <form method="POST" action="{{ route('admin.jadwal_mode.store') }}">
                    @csrf

                    <div class="field">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                               min="{{ today()->toDateString() }}" required>
                        @error('tanggal') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label>Mode Kerja</label>
                        <div class="mode-options">
                            <div class="mode-option">
                                <input type="radio" name="mode" id="mode_wfo" value="WFO"
                                       {{ old('mode', 'WFO') === 'WFO' ? 'checked' : '' }}>
                                <label for="mode_wfo" class="wfo">
                                    <i data-lucide="building-2"></i>
                                    <span class="mode-name">WFO</span>
                                    <span class="mode-desc">Di kantor</span>
                                </label>
                            </div>
                            <div class="mode-option">
                                <input type="radio" name="mode" id="mode_wfa" value="WFA"
                                       {{ old('mode') === 'WFA' ? 'checked' : '' }}>
                                <label for="mode_wfa" class="wfa">
                                    <i data-lucide="laptop"></i>
                                    <span class="mode-name">WFA</span>
                                    <span class="mode-desc">Remote / dari mana saja</span>
                                </label>
                            </div>
                        </div>
                        @error('mode') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label>Keterangan <span class="field-hint">(opsional)</span></label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                               placeholder="mis. WFA karena renovasi kantor">
                    </div>

                    <button type="submit" class="btn-save">
                        <i data-lucide="save" style="width:15px;height:15px;"></i> Simpan Jadwal
                    </button>
                </form>
            </div>
        </div>

        {{-- Daftar Jadwal --}}
        <div class="table-card">
            <div class="card-header">
                <i data-lucide="calendar-check" style="width:15px;height:15px;color:var(--green-dark);"></i>
                <span class="card-header-title">Daftar Jadwal</span>
                <span class="count-chip" style="margin-left:auto;">{{ $jadwals->count() }} jadwal</span>
            </div>

            @if($jadwals->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon"><i data-lucide="calendar-x"></i></div>
                    <p>Belum ada jadwal ditambahkan.<br>Semua hari berjalan dengan mode <strong>WFO</strong> (default).</p>
                </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mode</th>
                        <th>Keterangan</th>
                        <th>Dibuat Oleh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $jadwal)
                    <tr>
                        <td>
                            <div class="td-date">
                                {{ $jadwal->tanggal->translatedFormat('l, d M Y') }}
                                @if($jadwal->tanggal->isToday())
                                    <span class="today-badge">Hari Ini</span>
                                @endif
                            </div>
                            <div class="td-sub">{{ $jadwal->tanggal->translatedFormat('Y') }}</div>
                        </td>
                        <td>
                            <span class="mode-badge {{ $jadwal->mode }}">
                                @if($jadwal->mode === 'WFO')
                                    <i data-lucide="building-2"></i> WFO
                                @else
                                    <i data-lucide="laptop"></i> WFA
                                @endif
                            </span>
                        </td>
                        <td>
                            <span style="font-size:12px;color:var(--muted);">{{ $jadwal->keterangan ?? '—' }}</span>
                        </td>
                        <td>
                            <span style="font-size:12px;color:var(--muted);">{{ $jadwal->dibuatOleh->name ?? '—' }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.jadwal_mode.destroy', $jadwal->id) }}"
                                  onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i data-lucide="trash-2"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>
</main>

<script>lucide.createIcons();</script>
</body>
</html>
