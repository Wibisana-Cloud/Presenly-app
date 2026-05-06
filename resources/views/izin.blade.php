@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin & Cuti – Presenly</title>
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
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --gray: #64748b; --gray-light: #f8fafc; --white: #ffffff;
            --text: #1e293b; --border: #e2e8f0; --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --nav-h: 60px;
        }
        body { background: #f0f4f8; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; min-height: 100vh; padding-bottom: 80px; }

        /* TOPNAV */
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

        /* HEADER */
        .page-header { margin-bottom: 16px; animation: fadeUp 0.4s ease both; display: flex; align-items: center; gap: 12px; }
        .page-header-icon { width: 42px; height: 42px; background: var(--green-light); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .page-header-icon [data-lucide] { width: 20px; height: 20px; color: var(--green-dark); stroke-width: 2.5; }
        .page-header h1 { font-size: 20px; font-weight: 800; color: var(--dark); letter-spacing: -0.4px; }
        .page-sub { font-size: 12px; color: var(--gray); margin-top: 1px; }

        /* CARD */
        .card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 18px 20px; margin-bottom: 12px; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
        .card-title-row { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
        .card-title-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .card-title-icon.green { background: var(--green-light); }
        .card-title-icon.blue  { background: #dbeafe; }
        .card-title-icon [data-lucide] { width: 14px; height: 14px; stroke-width: 2.5; }
        .card-title-icon.green [data-lucide] { color: var(--green-dark); }
        .card-title-icon.blue  [data-lucide] { color: #1d4ed8; }
        .card-title { font-size: 13px; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; flex: 1; }
        .list-count { font-size: 12px; color: var(--gray); background: var(--gray-light); border: 1px solid var(--border); border-radius: 20px; padding: 2px 10px; font-weight: 600; }

        /* ALERT */
        .alert { padding: 11px 14px; border-radius: 10px; font-size: 13px; font-weight: 500; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; animation: fadeUp 0.3s ease both; }
        .alert [data-lucide] { width: 16px; height: 16px; flex-shrink: 0; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* FORM */
        .form-card { animation: fadeUp 0.4s 0.05s ease both; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: var(--gray); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.4px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray); pointer-events: none; }
        .input-icon [data-lucide] { width: 15px; height: 15px; }
        .has-icon { padding-left: 36px !important; }
        .form-control { width: 100%; padding: 10px 14px; background: var(--gray-light); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; outline: none; transition: all 0.2s; }
        .form-control:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
        .form-control::placeholder { color: #94a3b8; }
        .form-control option { background: var(--white); color: var(--text); }
        .form-error { color: var(--red); font-size: 12px; margin-top: 4px; display: block; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .submit-btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 16px rgba(34,197,94,0.3); display: flex; align-items: center; justify-content: center; gap: 8px; }
        .submit-btn [data-lucide] { width: 16px; height: 16px; }
        .submit-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(34,197,94,0.4); }

        /* LIST */
        .list-card { animation: fadeUp 0.4s 0.1s ease both; padding: 0; overflow: hidden; }
        .list-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
        .izin-list { display: flex; flex-direction: column; }

        .izin-item { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        .izin-item:last-child { border-bottom: none; }
        .izin-item:hover { background: #f8fafc; }

        .izin-item-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
        .izin-jenis { font-size: 14px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
        .izin-jenis-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .izin-jenis-icon.sakit    { background: #fef2f2; }
        .izin-jenis-icon.cuti     { background: #fef3c7; }
        .izin-jenis-icon.keperluan{ background: #ede9fe; }
        .izin-jenis-icon [data-lucide] { width: 14px; height: 14px; stroke-width: 2.5; }
        .izin-jenis-icon.sakit     [data-lucide] { color: var(--red); }
        .izin-jenis-icon.cuti      [data-lucide] { color: #92400e; }
        .izin-jenis-icon.keperluan [data-lucide] { color: #7c3aed; }

        .status-badge { font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 100px; }
        .status-badge.Pending   { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; }
        .status-badge.Disetujui { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .status-badge.Ditolak   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        .izin-meta { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--gray); margin-bottom: 6px; }
        .izin-meta [data-lucide] { width: 13px; height: 13px; flex-shrink: 0; }
        .izin-durasi { color: var(--green-dark); font-weight: 600; }
        .izin-keterangan { font-size: 13px; color: var(--text); line-height: 1.5; }

        .izin-catatan { margin-top: 8px; padding: 8px 12px; border-radius: 8px; font-size: 12px; display: flex; align-items: flex-start; gap: 6px; }
        .izin-catatan [data-lucide] { width: 13px; height: 13px; flex-shrink: 0; margin-top: 1px; }
        .izin-catatan.default  { background: var(--gray-light); color: var(--gray); border-left: 3px solid var(--border); }
        .izin-catatan.approved { background: var(--green-light); color: var(--green-dark); border-left: 3px solid var(--green); }
        .izin-catatan.rejected { background: #fef2f2; color: var(--red); border-left: 3px solid var(--red); }

        .cancel-btn { margin-top: 10px; padding: 6px 14px; background: transparent; border: 1.5px solid #fecaca; border-radius: 8px; color: var(--red); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .cancel-btn [data-lucide] { width: 13px; height: 13px; }
        .cancel-btn:hover { background: #fef2f2; }

        /* LAMPIRAN */
        .file-upload-wrap { border: 1.5px dashed var(--border); border-radius: 10px; padding: 12px 16px; background: var(--gray-light); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 10px; }
        .file-upload-wrap:hover { border-color: var(--green); background: #f0fdf4; }
        .file-upload-wrap [data-lucide] { width: 18px; height: 18px; color: var(--gray); flex-shrink: 0; }
        .file-upload-text { flex: 1; }
        .file-upload-label { font-size: 13px; font-weight: 600; color: var(--text); }
        .file-upload-sub { font-size: 11px; color: var(--gray); margin-top: 1px; }
        .file-name-display { font-size: 11px; color: var(--green-dark); font-weight: 600; margin-top: 1px; }
        .lampiran-link { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; color: var(--blue); font-weight: 600; text-decoration: none; margin-top: 6px; padding: 4px 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; transition: all 0.2s; }
        .lampiran-link:hover { background: #dbeafe; }
        .lampiran-link [data-lucide] { width: 12px; height: 12px; }

        /* EMPTY */
        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-state-icon { width: 64px; height: 64px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .empty-state-icon svg { width: 30px; height: 30px; stroke: #3b82f6; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .empty-state-title { font-size: 15px; font-weight: 700; color: var(--dark); margin-bottom: 6px; }
        .empty-state-sub { font-size: 13px; color: var(--gray); }

        /* BOTTOM NAV */
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
        <div class="page-header-icon">
            <i data-lucide="file-text"></i>
        </div>
        <div>
            <h1>Izin & Cuti</h1>
            <div class="page-sub">Pengajuan & riwayat izin kamu</div>
        </div>
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

    {{-- FORM PENGAJUAN --}}
    <div class="card form-card">
        <div class="card-title-row">
            <div class="card-title-icon green"><i data-lucide="plus-circle"></i></div>
            <span class="card-title">Ajukan Izin Baru</span>
        </div>
        <form method="POST" action="{{ route('izin.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Jenis Izin</label>
                <div class="input-wrap">
                    <span class="input-icon"><i data-lucide="tag"></i></span>
                    <select name="jenis_izin" class="form-control has-icon" required>
                        <option value="" disabled selected>Pilih jenis izin...</option>
                        <option value="Sakit"     {{ old('jenis_izin') == 'Sakit'     ? 'selected' : '' }}>Sakit</option>
                        <option value="Cuti"      {{ old('jenis_izin') == 'Cuti'      ? 'selected' : '' }}>Cuti</option>
                        <option value="Keperluan" {{ old('jenis_izin') == 'Keperluan' ? 'selected' : '' }}>Keperluan Pribadi</option>
                    </select>
                </div>
                @error('jenis_izin')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i data-lucide="calendar"></i></span>
                        <input type="date" name="tanggal_mulai" class="form-control has-icon"
                               value="{{ old('tanggal_mulai') }}"
                               min="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    @error('tanggal_mulai')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Selesai</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i data-lucide="calendar"></i></span>
                        <input type="date" name="tanggal_selesai" class="form-control has-icon"
                               value="{{ old('tanggal_selesai') }}"
                               min="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    @error('tanggal_selesai')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"
                          placeholder="Jelaskan alasan pengajuan izin..."
                          style="resize:vertical;" required>{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Lampiran <span style="color:var(--gray);font-weight:400;text-transform:none;letter-spacing:0;">(opsional)</span></label>
                <label class="file-upload-wrap" for="lampiran">
                    <i data-lucide="paperclip"></i>
                    <div class="file-upload-text">
                        <div class="file-upload-label" id="fileLabelText">Klik untuk pilih file</div>
                        <div class="file-upload-sub">PDF, JPG, PNG — maks. 5 MB</div>
                    </div>
                    <input type="file" id="lampiran" name="lampiran" accept=".pdf,.jpg,.jpeg,.png"
                           onchange="document.getElementById('fileLabelText').textContent = this.files[0]?.name ?? 'Klik untuk pilih file'">
                </label>
                @error('lampiran')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="submit-btn">
                <i data-lucide="send"></i>
                Kirim Pengajuan
            </button>
        </form>
    </div>

    {{-- RIWAYAT IZIN --}}
    <div class="card list-card">
        <div class="list-card-header">
            <div class="card-title-icon blue"><i data-lucide="list"></i></div>
            <span class="card-title">Riwayat Pengajuan</span>
            <span class="list-count">{{ $izins->count() }} total</span>
        </div>

        <div class="izin-list">
            @forelse($izins as $izin)
            <div class="izin-item">
                <div class="izin-item-top">
                    <span class="izin-jenis">
                        @if($izin->jenis_izin == 'Sakit')
                            <span class="izin-jenis-icon sakit"><i data-lucide="thermometer"></i></span>
                        @elseif($izin->jenis_izin == 'Cuti')
                            <span class="izin-jenis-icon cuti"><i data-lucide="umbrella"></i></span>
                        @else
                            <span class="izin-jenis-icon keperluan"><i data-lucide="briefcase"></i></span>
                        @endif
                        {{ $izin->jenis_izin }}
                    </span>
                    <span class="status-badge {{ $izin->status }}">{{ $izin->status }}</span>
                </div>

                <div class="izin-meta">
                    <i data-lucide="calendar-days"></i>
                    {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->translatedFormat('d M Y') }}
                    @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                        – {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->translatedFormat('d M Y') }}
                        <span class="izin-durasi">· {{ $izin->durasi }} hari</span>
                    @endif
                </div>

                <div class="izin-keterangan">{{ $izin->keterangan }}</div>

                @if($izin->lampiran)
                <a href="{{ Storage::url($izin->lampiran) }}" target="_blank" class="lampiran-link">
                    <i data-lucide="paperclip"></i>
                    Lihat Lampiran
                </a>
                @endif

                @if($izin->catatan_admin)
                <div class="izin-catatan {{ $izin->status == 'Disetujui' ? 'approved' : ($izin->status == 'Ditolak' ? 'rejected' : 'default') }}">
                    <i data-lucide="message-circle"></i>
                    <span>Admin: {{ $izin->catatan_admin }}</span>
                </div>
                @endif

                @if($izin->status == 'Pending')
                <form method="POST" action="{{ route('izin.destroy', $izin->id) }}"
                      onsubmit="return confirm('Batalkan pengajuan izin ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cancel-btn">
                        <i data-lucide="x"></i> Batalkan
                    </button>
                </form>
                @endif
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                </div>
                <div class="empty-state-title">Belum ada pengajuan izin</div>
                <div class="empty-state-sub">Gunakan form di atas untuk mengajukan izin atau cuti</div>
            </div>
            @endforelse
        </div>
    </div>

</main>

<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}">
        <i data-lucide="home"></i>
        Dashboard
    </a>
    <a href="{{ route('riwayat') }}">
        <i data-lucide="clock"></i>
        Riwayat
    </a>
    <a href="{{ route('izin.index') }}" class="active">
        <i data-lucide="file-text"></i>
        Izin
    </a>
    <a href="{{ route('profil') }}">
        <i data-lucide="user"></i>
        Profil
    </a>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>

</body>
</html>
