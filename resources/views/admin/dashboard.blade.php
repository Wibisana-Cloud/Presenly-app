<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin – Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --gray: #64748b; --white: #ffffff;
            --text: #1e293b; --border: #e2e8f0; --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --sidebar-w: 240px; --bg: #f1f5f9;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; min-height: 100vh; display: flex; }

        /* ── SIDEBAR GELAP ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: #0f172a;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            box-shadow: 4px 0 24px rgba(0,0,0,0.18);
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .logo-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 15px; color: white;
            box-shadow: 0 4px 12px rgba(34,197,94,0.4);
        }
        .logo-text { font-weight: 800; font-size: 16px; color: white; letter-spacing: -0.3px; }
        .logo-badge {
            font-size: 9px;
            background: rgba(34,197,94,0.18);
            border: 1px solid rgba(34,197,94,0.3);
            color: #4ade80;
            padding: 2px 7px; border-radius: 5px;
            margin-left: auto; font-weight: 700;
        }
        .sidebar-nav { flex: 1; padding: 12px; overflow-y: auto; }
        .nav-label {
            font-size: 10px;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 0 8px;
            margin: 16px 0 6px;
            font-weight: 600;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            border-radius: 9px;
            text-decoration: none;
            color: rgba(255,255,255,0.55);
            font-size: 13px; font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
            border: 1px solid transparent;
        }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.9); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(34,197,94,0.22), rgba(34,197,94,0.08));
            color: #4ade80;
            font-weight: 600;
            border-color: rgba(34,197,94,0.2);
        }
        .nav-item [data-lucide] { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-badge { margin-left: auto; background: var(--red); color: white; font-size: 10px; font-weight: 700; padding: 1px 7px; border-radius: 10px; }
        .sidebar-footer { padding: 12px; border-top: 1px solid rgba(255,255,255,0.07); }
        .admin-chip {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            margin-bottom: 8px;
        }
        .admin-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: white; flex-shrink: 0;
        }
        .admin-info { flex: 1; min-width: 0; }
        .admin-name { font-size: 12px; font-weight: 700; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-role { font-size: 10px; color: #4ade80; font-weight: 500; }
        .logout-btn {
            width: 100%; padding: 9px;
            background: transparent;
            border: 1px solid rgba(239,68,68,0.35);
            border-radius: 8px;
            color: #f87171;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.12); border-color: rgba(239,68,68,0.5); }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 48px; }

        /* PAGE HEADER */
        .page-header { margin-bottom: 24px; }
        .page-greeting { font-size: 13px; color: var(--gray); font-weight: 500; margin-bottom: 2px; }
        .page-title { font-size: 24px; font-weight: 800; color: var(--dark); letter-spacing: -0.6px; }

        /* ── STAT CARDS ── */
        .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 14px; }
        .stat-card {
            border-radius: 16px;
            padding: 18px 20px;
            display: flex; align-items: flex-start; gap: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            animation: fadeUp 0.4s ease both;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px; right: -20px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .stat-card.blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .stat-card.green  { background: linear-gradient(135deg, #22c55e, #16a34a); }
        .stat-card.yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-card.red    { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .stat-card-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-card-icon [data-lucide] { width: 20px; height: 20px; color: white; }
        .stat-card-body { flex: 1; }
        .stat-card-num { font-size: 28px; font-weight: 800; color: white; letter-spacing: -1px; line-height: 1; }
        .stat-card-label { font-size: 12px; color: rgba(255,255,255,0.8); margin-top: 4px; font-weight: 500; }
        .stat-card-sub { font-size: 10px; color: rgba(255,255,255,0.6); margin-top: 4px; }

        /* ── MODE ROW ── */
        .mode-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px; }
        .mode-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            display: flex; align-items: center; gap: 14px;
            animation: fadeUp 0.4s 0.1s ease both;
        }
        .mode-card-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .mode-card-icon.purple { background: linear-gradient(135deg, #a855f7, #7c3aed); }
        .mode-card-icon.green  { background: linear-gradient(135deg, #22c55e, #16a34a); }
        .mode-card-icon.blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .mode-card-icon [data-lucide] { width: 18px; height: 18px; color: white; }
        .mode-card-label { font-size: 11px; color: var(--gray); font-weight: 500; margin-bottom: 2px; }
        .mode-card-num { font-size: 22px; font-weight: 800; color: var(--dark); letter-spacing: -0.5px; line-height: 1; }
        .mode-card-badge { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; margin-top: 4px; display: inline-block; }
        .mode-card-badge.wfo { background: var(--green-light); color: var(--green-dark); }
        .mode-card-badge.wfa { background: #dbeafe; color: #1d4ed8; }
        .mode-card-sub { font-size: 11px; color: var(--gray); margin-top: 2px; }

        /* ── CARDS ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s 0.15s ease both;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: #fafbfc;
        }
        .card-title { font-size: 13px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
        .card-title [data-lucide] { width: 15px; height: 15px; color: var(--green-dark); }
        .card-sub { font-size: 11px; color: var(--gray); background: #f1f5f9; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .chart-legend { display: flex; gap: 14px; }
        .legend-item { display: flex; align-items: center; gap: 5px; font-size: 11px; color: var(--gray); font-weight: 500; }
        .legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .chart-body { padding: 20px; }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 11px 16px;
            text-align: left;
            font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;
            color: var(--gray); font-weight: 600;
            border-bottom: 1px solid var(--border);
            background: #fafbfc;
        }
        tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }
        tbody td { padding: 12px 16px; font-size: 13px; color: var(--text); }
        .user-cell { display: flex; align-items: center; gap: 10px; }
        .user-av {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: white; flex-shrink: 0;
        }
        .user-av-name { font-weight: 600; color: var(--dark); font-size: 13px; }
        .user-av-email { font-size: 11px; color: var(--gray); }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge.Hadir     { background: #dcfce7; color: #15803d; }
        .badge.Terlambat { background: #fef3c7; color: #92400e; }
        .badge.Alfa      { background: #fee2e2; color: #b91c1c; }
        .badge.Izin      { background: #dbeafe; color: #1d4ed8; }

        .empty-row td { text-align: center; padding: 48px; color: var(--gray); font-size: 13px; }

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
        <a href="{{ route('admin.dashboard') }}" class="nav-item active"><i data-lucide="layout-dashboard"></i> Dashboard</a>
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
        <a href="{{ route('admin.audit_log') }}" class="nav-item"><i data-lucide="shield-check"></i> Audit Log</a>
        <a href="{{ route('dashboard') }}" class="nav-item"><i data-lucide="user"></i> Tampilan Karyawan</a>
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

<!-- MAIN -->
<main class="main">
    <div class="page-header">
        <div class="page-greeting">{{ now()->translatedFormat('l, d F Y') }}</div>
        <h1 class="page-title">Dashboard Admin</h1>
    </div>

    <!-- STAT CARDS -->
    <div class="stat-cards">
        <div class="stat-card blue">
            <div class="stat-card-icon"><i data-lucide="users"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-num">{{ $totalKaryawan }}</div>
                <div class="stat-card-label">Total Karyawan</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-card-icon"><i data-lucide="check-circle"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-num" id="stat-hadir">{{ $hadirHariIni }}</div>
                <div class="stat-card-label">Hadir Hari Ini</div>
                <div class="stat-card-sub">Bulan ini: {{ $totalHadirBulan }} hari</div>
            </div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-card-icon"><i data-lucide="clock"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-num" id="stat-terlambat">{{ $terlambatHariIni }}</div>
                <div class="stat-card-label">Terlambat Hari Ini</div>
                <div class="stat-card-sub">Bulan ini: {{ $totalTerlambatBulan }} kali</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-icon"><i data-lucide="x-circle"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-num" id="stat-alfa">{{ $alfaHariIni }}</div>
                <div class="stat-card-label">Alfa Hari Ini</div>
                <div class="stat-card-sub">Bulan ini: {{ $totalAlfaBulan }} kali</div>
            </div>
        </div>
    </div>

    <!-- MODE KERJA -->
    <div class="mode-row">
        <div class="mode-card">
            <div class="mode-card-icon purple"><i data-lucide="calendar-check"></i></div>
            <div>
                <div class="mode-card-label">Mode Hari Ini</div>
                <div class="mode-card-num">{{ $modeHariIni }}</div>
                <span class="mode-card-badge {{ strtolower($modeHariIni) }}">
                    {{ $modeHariIni === 'WFA' ? 'Remote' : 'Di Kantor' }}
                </span>
            </div>
        </div>
        <div class="mode-card">
            <div class="mode-card-icon green"><i data-lucide="building-2"></i></div>
            <div>
                <div class="mode-card-label">Absen WFO Hari Ini</div>
                <div class="mode-card-num" id="stat-wfo">{{ $wfoHariIni }}</div>
                <div class="mode-card-sub">karyawan</div>
            </div>
        </div>
        <div class="mode-card">
            <div class="mode-card-icon blue"><i data-lucide="laptop"></i></div>
            <div>
                <div class="mode-card-label">Absen WFA Hari Ini</div>
                <div class="mode-card-num" id="stat-wfa">{{ $wfaHariIni }}</div>
                <div class="mode-card-sub">karyawan</div>
            </div>
        </div>
    </div>

    <!-- GRAFIK -->
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i data-lucide="bar-chart-2"></i> Kehadiran Harian — {{ now()->translatedFormat('F Y') }}</span>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-dot" style="background:#22c55e"></span> Hadir</span>
                <span class="legend-item"><span class="legend-dot" style="background:#f59e0b"></span> Terlambat</span>
                <span class="legend-item"><span class="legend-dot" style="background:#ef4444"></span> Alfa</span>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="grafikKehadiran" height="80"></canvas>
        </div>
    </div>

    <!-- TABEL ABSENSI -->
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i data-lucide="clock"></i> Absensi Hari Ini</span>
            <div style="display:flex;align-items:center;gap:10px;">
                <span class="card-sub">{{ now()->translatedFormat('d F Y') }}</span>
                <span id="refresh-indicator" style="font-size:10px;color:var(--gray);display:flex;align-items:center;gap:4px;">
                    <span id="refresh-dot" style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                    <span id="refresh-time">Live</span>
                </span>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Jarak</th>
                    <th>Durasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="absensi-tbody">
                @forelse($absensiTerbaru as $item)
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-av">{{ strtoupper(substr($item->user->name ?? 'K', 0, 1)) }}</div>
                            <div>
                                <div class="user-av-name">{{ $item->user->name ?? '-' }}</div>
                                <div class="user-av-email">{{ $item->user->email ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--green-dark);font-weight:600;">
                        {{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}
                    </td>
                    <td>{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
                    <td style="color:var(--gray);">{{ $item->jarak_meter ? number_format($item->jarak_meter, 0).' m' : '-' }}</td>
                    <td style="color:var(--gray);">{{ $item->durasi_kerja ?? '-' }}</td>
                    <td><span class="badge {{ $item->status }}">{{ $item->status ?? '-' }}</span></td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="6">Belum ada absensi hari ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script>
    lucide.createIcons();

    // ── AUTO-REFRESH every 60s ──
    const statsUrl = '{{ route('admin.dashboard.stats') }}';

    function animateNum(el, newVal) {
        const old = parseInt(el.textContent);
        if (old === newVal) { return; }
        el.style.transform = 'scale(1.25)';
        el.style.transition = 'transform 0.25s ease';
        el.textContent = newVal;
        setTimeout(() => { el.style.transform = 'scale(1)'; }, 250);
    }

    function badgeClass(status) {
        const map = { Hadir: 'Hadir', Terlambat: 'Terlambat', Alfa: 'Alfa', Izin: 'Izin' };
        return map[status] || '';
    }

    function refreshStats() {
        const dot = document.getElementById('refresh-dot');
        dot.style.background = '#f59e0b';

        fetch(statsUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                animateNum(document.getElementById('stat-hadir'), data.hadirHariIni);
                animateNum(document.getElementById('stat-terlambat'), data.terlambatHariIni);
                animateNum(document.getElementById('stat-alfa'), data.alfaHariIni);
                animateNum(document.getElementById('stat-wfo'), data.wfoHariIni);
                animateNum(document.getElementById('stat-wfa'), data.wfaHariIni);

                // Update table
                const tbody = document.getElementById('absensi-tbody');
                if (data.absensiTerbaru.length === 0) {
                    tbody.innerHTML = '<tr class="empty-row"><td colspan="6">Belum ada absensi hari ini</td></tr>';
                } else {
                    tbody.innerHTML = data.absensiTerbaru.map(item => `
                        <tr>
                            <td><div class="user-cell">
                                <div class="user-av">${item.name.charAt(0).toUpperCase()}</div>
                                <div><div class="user-av-name">${item.name}</div><div class="user-av-email">${item.email}</div></div>
                            </div></td>
                            <td style="color:var(--green-dark);font-weight:600;">${item.jam_masuk}</td>
                            <td>${item.jam_pulang}</td>
                            <td style="color:var(--gray);">${item.jarak_meter}</td>
                            <td style="color:var(--gray);">${item.durasi_kerja}</td>
                            <td><span class="badge ${badgeClass(item.status)}">${item.status}</span></td>
                        </tr>`).join('');
                }

                document.getElementById('refresh-time').textContent = data.updatedAt;
                dot.style.background = '#22c55e';
            })
            .catch(() => { dot.style.background = '#ef4444'; });
    }

    setInterval(refreshStats, 60000);

    new Chart(document.getElementById('grafikKehadiran'), {
        type: 'bar',
        data: {
            labels: @json($grafikLabels),
            datasets: [
                { label: 'Hadir',     data: @json($grafikHadir),     backgroundColor: 'rgba(34,197,94,0.75)',  borderRadius: 6, borderSkipped: false },
                { label: 'Terlambat', data: @json($grafikTerlambat), backgroundColor: 'rgba(245,158,11,0.75)', borderRadius: 6, borderSkipped: false },
                { label: 'Alfa',      data: @json($grafikAlfa),      backgroundColor: 'rgba(239,68,68,0.75)',  borderRadius: 6, borderSkipped: false },
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    borderColor: '#1e293b',
                    borderWidth: 1,
                    titleColor: '#f1f5f9',
                    bodyColor: '#94a3b8',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: { title: function(items) { return 'Tanggal ' + items[0].label; } }
                }
            },
            scales: {
                x: { grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 11, family: 'Plus Jakarta Sans' } }, border: { color: '#e2e8f0' } },
                y: { beginAtZero: true, ticks: { color: '#94a3b8', font: { size: 11, family: 'Plus Jakarta Sans' }, stepSize: 1 }, grid: { color: '#f1f5f9' }, border: { color: '#e2e8f0' } }
            }
        }
    });
</script>
</body>
</html>
