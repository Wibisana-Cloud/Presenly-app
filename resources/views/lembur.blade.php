<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembur – Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
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
        .logo-icon { width: 30px; height: 30px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; color: white; }
        .logo-text { font-size: 16px; font-weight: 800; color: white; letter-spacing: -0.3px; }
        .topnav-right { display: flex; align-items: center; gap: 10px; }
        .user-chip { display: flex; align-items: center; gap: 8px; }
        .user-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--green-dark)); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; }
        .user-name { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.85); }
        .logout-btn { display: flex; align-items: center; gap: 6px; padding: 6px 14px; background: transparent; border: 1px solid rgba(239,68,68,0.4); border-radius: 7px; color: #fca5a5; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .logout-btn:hover { background: rgba(239,68,68,0.12); }
        main { padding-top: calc(var(--nav-h) + 20px); padding-bottom: 90px; max-width: 520px; margin: 0 auto; padding-left: 16px; padding-right: 16px; }
        .page-header { margin-bottom: 16px; }
        .page-header h1 { font-size: 20px; font-weight: 800; color: var(--dark); letter-spacing: -0.4px; }
        .page-sub { font-size: 12px; color: var(--gray); margin-top: 1px; }
        .card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 18px 20px; margin-bottom: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .card-title-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .card-title { font-size: 13px; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group { margin-bottom: 12px; }
        .form-label { font-size: 12px; font-weight: 600; color: var(--gray); margin-bottom: 6px; display: block; }
        .form-control { width: 100%; padding: 10px 14px; background: var(--gray-light); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .form-control:focus { border-color: var(--green); background: #f0fdf4; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .btn-submit { width: 100%; padding: 12px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 12px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 3px 10px rgba(34,197,94,0.3); }
        .btn-submit:hover { transform: translateY(-1px); }
        .filter-row { display: flex; gap: 8px; flex-wrap: wrap; }
        .filter-select { flex: 1; padding: 9px 12px; background: var(--gray-light); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .filter-select:focus { border-color: var(--green); }
        .filter-btn { display: flex; align-items: center; gap: 6px; padding: 9px 16px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
        .list-card { padding: 0; overflow: hidden; }
        .list-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .list-count { font-size: 12px; color: var(--gray); background: var(--gray-light); border: 1px solid var(--border); border-radius: 20px; padding: 2px 10px; font-weight: 600; }
        .lembur-item { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; }
        .lembur-item:last-child { border-bottom: none; }
        .lembur-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; }
        .lembur-tanggal { font-size: 14px; font-weight: 700; color: var(--dark); }
        .lembur-hari { font-size: 11px; color: var(--gray); margin-top: 1px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; flex-shrink: 0; }
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-disetujui { background: var(--green-light); color: var(--green-dark); }
        .badge-ditolak   { background: #fef2f2; color: var(--red); }
        .lembur-detail { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 8px; }
        .detail-box { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 10px; padding: 8px 12px; }
        .detail-box-label { font-size: 10px; color: var(--gray); font-weight: 600; margin-bottom: 3px; text-transform: uppercase; letter-spacing: 0.3px; }
        .detail-box-value { font-size: 13px; font-weight: 700; color: var(--dark); }
        .detail-box-value.green { color: var(--green-dark); }
        .keterangan-text { font-size: 12px; color: var(--gray); background: #f8fafc; border-radius: 8px; padding: 8px 12px; margin-top: 6px; }
        .btn-cancel { font-size: 11px; color: var(--red); background: #fef2f2; border: 1px solid #fecaca; padding: 4px 12px; border-radius: 8px; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; transition: all 0.2s; }
        .btn-cancel:hover { background: #fee2e2; }
        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-state-title { font-size: 15px; font-weight: 700; color: var(--dark); margin-bottom: 6px; }
        .empty-state-sub { font-size: 13px; color: var(--gray); }
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: var(--white); border-top: 1px solid var(--border); display: flex; box-shadow: 0 -4px 20px rgba(0,0,0,0.08); z-index: 100; padding-bottom: env(safe-area-inset-bottom, 0); }
        .bottom-nav a { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 10px 0; text-decoration: none; color: #94a3b8; font-size: 10px; font-weight: 600; transition: all 0.2s; position: relative; }
        .bottom-nav a.active { color: var(--green-dark); }
        .bottom-nav a.active::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 28px; height: 3px; background: linear-gradient(90deg, var(--green-dark), var(--green)); border-radius: 0 0 3px 3px; }
        .bottom-nav a [data-lucide] { width: 20px; height: 20px; stroke-width: 2; }
        .alert-success { background: #f0fdf4; border: 1px solid var(--green-mid); color: var(--green-dark); padding: 10px 16px; border-radius: 10px; margin-bottom: 12px; font-size: 13px; font-weight: 600; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); padding: 10px 16px; border-radius: 10px; margin-bottom: 12px; font-size: 13px; font-weight: 600; }
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
        <h1>Lembur</h1>
        <div class="page-sub">Pengajuan dan riwayat lembur kamu</div>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    {{-- Form Ajukan Lembur --}}
    <div class="card">
        <div class="card-title-row">
            <span class="card-title">Ajukan Lembur</span>
        </div>
        <form method="POST" action="{{ route('lembur.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Tanggal Lembur</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan (opsional)</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Alasan atau deskripsi lembur...">{{ old('keterangan') }}</textarea>
            </div>
            <button type="submit" class="btn-submit">Kirim Pengajuan</button>
        </form>
    </div>

    {{-- Filter --}}
    <div class="card" style="padding:14px 18px;">
        <form method="GET" action="{{ route('lembur.index') }}">
            <div class="filter-row">
                <select name="bulan" class="filter-select">
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(null, (int) $m, 1)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
                <select name="tahun" class="filter-select">
                    @foreach($tahunList as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-btn">
                    <i data-lucide="search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Daftar Lembur --}}
    <div class="card list-card">
        <div class="list-card-header">
            <span class="card-title">Riwayat Lembur</span>
            <span class="list-count">{{ $lemburans->count() }} data</span>
        </div>

        @if($lemburans->isEmpty())
        <div class="empty-state">
            <div class="empty-state-title">Belum ada pengajuan lembur</div>
            <div class="empty-state-sub">Ajukan lembur menggunakan form di atas</div>
        </div>
        @else
        @foreach($lemburans as $item)
        @php $statusLower = strtolower($item->status); @endphp
        <div class="lembur-item">
            <div class="lembur-top">
                <div>
                    <div class="lembur-tanggal">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                    <div class="lembur-hari">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</div>
                </div>
                <span class="badge badge-{{ $statusLower }}">{{ $item->status }}</span>
            </div>
            <div class="lembur-detail">
                <div class="detail-box">
                    <div class="detail-box-label">Mulai</div>
                    <div class="detail-box-value green">{{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-box-label">Selesai</div>
                    <div class="detail-box-value">{{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-box-label">Durasi</div>
                    <div class="detail-box-value">{{ $item->durasi_lembur ?? '-' }}</div>
                </div>
            </div>
            @if($item->keterangan)
            <div class="keterangan-text">{{ $item->keterangan }}</div>
            @endif
            @if($item->status === 'Pending')
            <div style="margin-top:10px;">
                <form method="POST" action="{{ route('lembur.destroy', $item->id) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-cancel">Batalkan</button>
                </form>
            </div>
            @endif
        </div>
        @endforeach
        @endif
    </div>
</main>

<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}"><i data-lucide="home"></i> Beranda</a>
    <a href="{{ route('riwayat') }}"><i data-lucide="clock"></i> Riwayat</a>
    <a href="{{ route('lembur.index') }}" class="active"><i data-lucide="timer"></i> Lembur</a>
    <a href="{{ route('izin.index') }}"><i data-lucide="file-clock"></i> Izin</a>
    <a href="{{ route('profil') }}"><i data-lucide="user"></i> Profil</a>
</nav>

<script>lucide.createIcons();</script>
</body>
</html>
