<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – Presenly</title>
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
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #22c55e;
            --green-dark: #16a34a;
            --green-light: #dcfce7;
            --green-mid: #bbf7d0;
            --dark: #0f172a;
            --gray: #64748b;
            --gray-light: #f8fafc;
            --white: #ffffff;
            --text: #1e293b;
            --border: #e2e8f0;
            --red: #ef4444;
            --yellow: #f59e0b;
            --blue: #3b82f6;
            --nav-h: 60px;
        }

        body {
            background: #f0f4f8;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            line-height: 1.6;
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .topnav {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--nav-h);
            background: #0f172a;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 20px; z-index: 100;
            box-shadow: 0 2px 16px rgba(0,0,0,0.15);
        }
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
        .admin-switch-btn { display: flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 7px; color: rgba(255,255,255,0.85); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .admin-switch-btn:hover { background: rgba(255,255,255,0.18); }
        .admin-switch-btn [data-lucide] { width: 13px; height: 13px; }

        main {
            padding-top: calc(var(--nav-h) + 20px);
            padding-bottom: 90px;
            max-width: 520px;
            margin: 0 auto;
            padding-left: 16px;
            padding-right: 16px;
        }

        /* BANNER HARI LIBUR */
        .banner-libur {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeUp 0.4s ease both;
        }
        .banner-libur.weekend { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
        .banner-libur.nasional { background: #fef3c7; color: #92400e; border: 1.5px solid #fde68a; }
        .banner-libur-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .banner-libur.weekend .banner-libur-icon { background: #dbeafe; }
        .banner-libur.nasional .banner-libur-icon { background: #fde68a; }
        .banner-libur-icon [data-lucide] { width: 18px; height: 18px; }
        .banner-libur-title { font-size: 13px; font-weight: 700; }
        .banner-libur-sub { font-size: 11px; opacity: 0.8; margin-top: 2px; }

        .page-header { margin-bottom: 16px; animation: fadeUp 0.4s ease both; display: flex; align-items: center; justify-content: space-between; }
        .page-header-left h1 { font-size: 22px; font-weight: 800; color: var(--dark); letter-spacing: -0.5px; }
        .page-date { font-size: 12px; color: var(--gray); margin-top: 2px; font-weight: 500; }
        .notif-btn { position: relative; width: 38px; height: 38px; background: var(--white); border: 1.5px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06); color: var(--gray); transition: all 0.2s; }
        .notif-btn:hover { border-color: var(--green-mid); color: var(--green-dark); }
        .notif-btn [data-lucide] { width: 18px; height: 18px; }
        .notif-dot { position: absolute; top: 6px; right: 6px; width: 8px; height: 8px; background: var(--red); border-radius: 50%; border: 2px solid white; animation: pulse 1.5s infinite; }

        /* BANNER IZIN */
        .banner-izin { width: 100%; padding: 14px 16px; border-radius: 12px; margin-bottom: 12px; display: flex; align-items: flex-start; gap: 12px; animation: fadeUp 0.4s ease both; }
        .banner-izin.disetujui { background: var(--green-light); border: 1.5px solid var(--green-mid); color: var(--green-dark); }
        .banner-izin.ditolak { background: #fef2f2; border: 1.5px solid #fecaca; color: var(--red); }
        .banner-izin-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .banner-izin.disetujui .banner-izin-icon { background: #bbf7d0; }
        .banner-izin.ditolak .banner-izin-icon { background: #fecaca; }
        .banner-izin-icon [data-lucide] { width: 18px; height: 18px; }
        .banner-izin-body { flex: 1; }
        .banner-izin-title { font-size: 13px; font-weight: 700; }
        .banner-izin-sub { font-size: 11px; opacity: 0.85; margin-top: 2px; line-height: 1.4; }
        .banner-izin-link { font-size: 11px; font-weight: 700; margin-top: 6px; display: inline-block; text-decoration: underline; }
        .banner-izin .banner-izin-close { background: none; border: none; cursor: pointer; color: inherit; font-size: 18px; padding: 0; line-height: 1; flex-shrink: 0; opacity: 0.6; }

        .card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 18px 20px; margin-bottom: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .status-card { animation: fadeUp 0.4s 0.05s ease both; border-top: 3px solid var(--green) !important; }
        .status-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .status-card-label { font-size: 11px; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: 0.6px; }
        .jam-realtime { font-size: 28px; font-weight: 800; letter-spacing: -1px; font-variant-numeric: tabular-nums; }
        .clock-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #bbf7d0, #dcfce7); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(34,197,94,0.2); }
        .clock-icon [data-lucide] { width: 18px; height: 18px; color: var(--green-dark); stroke-width: 2.5; }
        .jam-realtime { font-size: 32px; font-weight: 800; color: var(--dark); letter-spacing: -1.5px; font-variant-numeric: tabular-nums; background: linear-gradient(135deg, var(--dark), #334155); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        .gps-rows { display: flex; flex-direction: column; gap: 6px; margin-top: 4px; }
        .gps-row { display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 10px; transition: border-color 0.2s; }
        .gps-row:hover { border-color: var(--border); }
        .gps-row-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .gps-row-icon.green  { background: linear-gradient(135deg, #bbf7d0, #dcfce7); }
        .gps-row-icon.blue   { background: linear-gradient(135deg, #bfdbfe, #dbeafe); }
        .gps-row-icon.purple { background: linear-gradient(135deg, #ddd6fe, #ede9fe); }
        .gps-row-icon.orange { background: linear-gradient(135deg, #fed7aa, #ffedd5); }
        .gps-row-icon [data-lucide] { width: 13px; height: 13px; stroke-width: 2.5; }
        .gps-row-icon.green  [data-lucide] { color: #15803d; }
        .gps-row-icon.blue   [data-lucide] { color: #1d4ed8; }
        .gps-row-icon.purple [data-lucide] { color: #7c3aed; }
        .gps-row-icon.orange [data-lucide] { color: #c2410c; }
        .gps-row-label { font-size: 12px; color: var(--gray); flex: 1; }
        .gps-row-value { font-size: 13px; font-weight: 700; color: var(--dark); }
        .gps-row-value.green { color: var(--green-dark); }
        .gps-row-value.blue { color: var(--blue); }
        .gps-row-value.orange { color: #f59e0b; }

        .gps-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 700; }
        .gps-badge.inside { background: var(--green-light); color: var(--green-dark); }
        .gps-badge.outside { background: #fef2f2; color: var(--red); }
        .gps-badge.detecting { background: #fef3c7; color: #92400e; }
        .gps-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .gps-badge.detecting { animation: pulse 1.2s infinite; }

        .wfa-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: var(--gray-light); border-radius: 10px; border: 1.5px solid var(--border); transition: all 0.3s; }
        .wfa-toggle-row.wfa-active { background: #eff6ff; border-color: #bfdbfe; }
        .wfa-toggle-left { display: flex; align-items: center; gap: 10px; }
        .wfa-toggle-icon { width: 26px; height: 26px; border-radius: 7px; background: #dbeafe; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .wfa-toggle-icon [data-lucide] { width: 13px; height: 13px; stroke-width: 2.5; color: #1d4ed8; }
        .wfa-toggle-texts { display: flex; flex-direction: column; }
        .wfa-toggle-title { font-size: 12px; font-weight: 700; color: var(--dark); }
        .wfa-toggle-sub { font-size: 10px; color: var(--gray); margin-top: 1px; }

        .switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; inset: 0; background: #cbd5e1; border-radius: 24px; transition: 0.3s; }
        .slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: white; border-radius: 50%; transition: 0.3s; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
        input:checked+.slider { background: var(--blue); }
        input:checked+.slider::before { transform: translateX(20px); }

        .checkin-card { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; animation: fadeUp 0.4s 0.1s ease both; }
        .checkin-btn { padding: 18px 16px; border-radius: 14px; border: none; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.25s; display: flex; flex-direction: column; align-items: center; gap: 6px; position: relative; overflow: hidden; }
        .checkin-btn::before { content: ''; position: absolute; inset: 0; background: rgba(255,255,255,0.08); opacity: 0; transition: opacity 0.2s; }
        .checkin-btn:not(:disabled):hover::before { opacity: 1; }
        .checkin-btn [data-lucide] { width: 24px; height: 24px; stroke-width: 2; }
        .checkin-btn.in { background: linear-gradient(135deg, #16a34a, #22c55e); color: white; box-shadow: 0 6px 20px rgba(34,197,94,0.35); }
        .checkin-btn.in:not(:disabled):hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(34,197,94,0.45); }
        .checkin-btn.out { background: linear-gradient(135deg, #dc2626, #ef4444); color: white; box-shadow: 0 6px 20px rgba(239,68,68,0.35); }
        .checkin-btn.out:not(:disabled):hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(239,68,68,0.45); }
        .checkin-btn.out[disabled]:not([data-sudah-pulang]) { background: #e2e8f0; color: var(--gray); box-shadow: none; }
        .checkin-btn:disabled { opacity: 0.45; cursor: not-allowed; transform: none !important; }

        .gps-info-box { display: none; margin-top: 6px; padding: 8px 12px; background: #fef3c7; border: 1px solid #fde68a; border-radius: 8px; font-size: 11px; color: #92400e; text-align: center; font-weight: 500; }
        .gps-info-box.show { display: block; }

        .stats-card { animation: fadeUp 0.4s 0.15s ease both; }
        .card-title-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .card-title { font-size: 13px; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; }
        .month-badge { font-size: 11px; color: var(--gray); background: var(--gray-light); border: 1px solid var(--border); border-radius: 6px; padding: 2px 8px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 14px; }
        .stat-item { text-align: center; padding: 14px 8px; border-radius: 12px; position: relative; overflow: hidden; }
        .stat-item.green  { background: linear-gradient(135deg, #16a34a, #22c55e); box-shadow: 0 4px 14px rgba(34,197,94,0.25); }
        .stat-item.yellow { background: linear-gradient(135deg, #d97706, #f59e0b); box-shadow: 0 4px 14px rgba(245,158,11,0.25); }
        .stat-item.red    { background: linear-gradient(135deg, #dc2626, #ef4444); box-shadow: 0 4px 14px rgba(239,68,68,0.25); }
        .stat-num { font-size: 28px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 3px; color: white; }
        .stat-label { font-size: 10px; color: rgba(255,255,255,0.85); font-weight: 600; letter-spacing: 0.2px; }
        .progress-wrap { margin-top: 4px; }
        .progress-label { display: flex; justify-content: space-between; font-size: 12px; color: var(--gray); margin-bottom: 6px; }
        .progress-label span:last-child { color: var(--green-dark); font-weight: 700; }
        .progress-bar { height: 8px; background: var(--border); border-radius: 4px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #16a34a, #22c55e, #4ade80); border-radius: 4px; transition: width 1.2s cubic-bezier(0.4,0,0.2,1); box-shadow: 0 0 8px rgba(34,197,94,0.4); }

        .chart-card { animation: fadeUp 0.4s 0.18s ease both; border-top: 3px solid #3b82f6 !important; }
        .chart-wrap { position: relative; height: 180px; margin-top: 4px; }

        .riwayat-card { animation: fadeUp 0.4s 0.2s ease both; }
        .riwayat-link { font-size: 12px; color: var(--green-dark); text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 4px; }
        .riwayat-list { display: flex; flex-direction: column; gap: 6px; }
        .riwayat-item { display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: #f8fafc; border: 1.5px solid #f1f5f9; border-radius: 12px; transition: all 0.2s; }
        .riwayat-item:hover { border-color: var(--green-mid); background: #f0fdf4; transform: translateX(2px); }
        .riwayat-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
        .riwayat-dot.hadir { background: var(--green); box-shadow: 0 0 0 3px rgba(34,197,94,0.2); }
        .riwayat-dot.terlambat { background: var(--yellow); box-shadow: 0 0 0 3px rgba(245,158,11,0.2); }
        .riwayat-dot.alfa { background: var(--red); box-shadow: 0 0 0 3px rgba(239,68,68,0.2); }
        .riwayat-dot.izin { background: var(--blue); box-shadow: 0 0 0 3px rgba(59,130,246,0.2); }
        .riwayat-info { flex: 1; }
        .riwayat-tanggal { font-size: 13px; font-weight: 600; color: var(--dark); }
        .riwayat-jam { font-size: 11px; color: var(--gray); margin-top: 1px; }
        .riwayat-right { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
        .riwayat-status { font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 100px; }
        .riwayat-status.hadir { background: var(--green-light); color: var(--green-dark); }
        .riwayat-status.terlambat { background: #fef3c7; color: #92400e; }
        .riwayat-status.alfa { background: #fef2f2; color: var(--red); }
        .riwayat-status.izin { background: #dbeafe; color: #1d4ed8; }
        .mode-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 100px; background: #eff6ff; color: #1d4ed8; }
        .mode-badge [data-lucide] { width: 10px; height: 10px; }
        .pengumuman-card { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 14px; padding: 14px 16px; margin-bottom: 12px; animation: fadeUp 0.4s ease both; }
        .pengumuman-header { display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; }
        .pengumuman-item { padding: 10px 0; border-bottom: 1px solid #fde68a; }
        .pengumuman-item:last-child { border-bottom: none; padding-bottom: 0; }
        .pengumuman-judul { font-size: 13px; font-weight: 700; color: var(--dark); }
        .pengumuman-isi { font-size: 12px; color: var(--gray); margin-top: 3px; line-height: 1.5; }
        .empty-state { text-align: center; padding: 32px 20px; }
        .empty-state-icon { width: 52px; height: 52px; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
        .empty-state-icon svg { width: 24px; height: 24px; stroke: #16a34a; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .empty-state-title { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 4px; }
        .empty-state-sub { font-size: 12px; color: var(--gray); }

        .toast-wrap { position: fixed; top: 70px; left: 50%; transform: translateX(-50%); z-index: 999; width: 90%; max-width: 420px; display: flex; flex-direction: column; gap: 8px; pointer-events: none; }
        .toast { padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 10px; pointer-events: all; animation: fadeUp 0.3s ease both; box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
        .toast.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .toast.error { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }
        .toast.warning { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; }
        .toast.info { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }
        .toast-close { margin-left: auto; background: none; border: none; cursor: pointer; color: inherit; font-size: 16px; padding: 0; }

        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: var(--white); border-top: 1px solid var(--border); display: flex; box-shadow: 0 -4px 20px rgba(0,0,0,0.08); z-index: 100; padding-bottom: env(safe-area-inset-bottom, 0); }
        .bottom-nav a { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 10px 0; text-decoration: none; color: #94a3b8; font-size: 10px; font-weight: 600; transition: all 0.2s; position: relative; }
        .bottom-nav a.active { color: var(--green-dark); }
        .bottom-nav a:hover { color: var(--green-dark); }
        .bottom-nav a.active::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 28px; height: 3px; background: linear-gradient(90deg, var(--green-dark), var(--green)); border-radius: 0 0 3px 3px; }
        .bottom-nav a [data-lucide] { width: 20px; height: 20px; stroke-width: 2; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
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
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <span class="user-name">{{ Auth::user()->name ?? 'Karyawan' }}</span>
        </div>
        <a href="{{ route('riwayat') }}" class="admin-switch-btn" style="background:#3b82f6;">
            <i data-lucide="history"></i> Riwayat
        </a>
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

<div class="toast-wrap" id="toastWrap"></div>

<main>

    {{-- BANNER NOTIFIKASI IZIN --}}
    @foreach($izinDiproses as $loop_izin)
    <div class="banner-izin {{ strtolower($loop_izin->status) }}" id="bannerIzin{{ $loop_izin->id }}">
        <div class="banner-izin-icon">
            @if($loop_izin->status === 'Disetujui')
                <i data-lucide="check-circle"></i>
            @else
                <i data-lucide="x-circle"></i>
            @endif
        </div>
        <div class="banner-izin-body">
            <div class="banner-izin-title">
                Izin {{ $loop_izin->jenis_izin }} {{ $loop_izin->status === 'Disetujui' ? 'Disetujui' : 'Ditolak' }}
            </div>
            <div class="banner-izin-sub">
                {{ \Carbon\Carbon::parse($loop_izin->tanggal_mulai)->translatedFormat('d M') }}
                @if($loop_izin->tanggal_mulai != $loop_izin->tanggal_selesai)
                    – {{ \Carbon\Carbon::parse($loop_izin->tanggal_selesai)->translatedFormat('d M Y') }}
                @else
                    {{ \Carbon\Carbon::parse($loop_izin->tanggal_mulai)->translatedFormat('Y') }}
                @endif
                @if($loop_izin->catatan_admin)
                    · "{{ $loop_izin->catatan_admin }}"
                @endif
            </div>
            <a href="{{ route('izin.index') }}" class="banner-izin-link">Lihat Detail →</a>
        </div>
        <button class="banner-izin-close" onclick="document.getElementById('bannerIzin{{ $loop_izin->id }}').remove()">×</button>
    </div>
    @endforeach

    {{-- BANNER HARI LIBUR --}}
    @if($hariIniAkhirPekan)
    <div class="banner-libur weekend">
        <div class="banner-libur-icon"><i data-lucide="moon"></i></div>
        <div>
            <div class="banner-libur-title">Hari {{ $namaAkhirPekan }} — Selamat Istirahat!</div>
            <div class="banner-libur-sub">Tombol absen tetap tersedia jika Anda masuk kerja.</div>
        </div>
    </div>
    @elseif($hariIniLibur)
    <div class="banner-libur nasional">
        <div class="banner-libur-icon"><i data-lucide="party-popper"></i></div>
        <div>
            <div class="banner-libur-title">Hari Libur Nasional</div>
            <div class="banner-libur-sub">{{ $namaHariLibur }} — Tombol absen tetap tersedia jika Anda masuk kerja.</div>
        </div>
    </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1>Dashboard</h1>
            <div class="page-date" id="tanggal-hari">Memuat...</div>
        </div>
        <a href="{{ route('izin.index') }}" class="notif-btn">
            <i data-lucide="bell"></i>
            @if($izinDiproses->isNotEmpty())
                <span class="notif-dot"></span>
            @endif
        </a>
    </div>

    {{-- PENGUMUMAN --}}
    @if($pengumuman->isNotEmpty())
    <div class="pengumuman-card">
        <div class="pengumuman-header"><i data-lucide="megaphone"></i> Pengumuman</div>
        @foreach($pengumuman as $p)
        <div class="pengumuman-item">
            <div class="pengumuman-judul">{{ $p->judul }}</div>
            <div class="pengumuman-isi">{{ Str::limit($p->isi, 120) }}</div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- STATUS KEHADIRAN --}}
    <div class="card status-card">
        <div class="status-card-top">
            <div>
                <div class="status-card-label">Status Kehadiran</div>
                <div class="jam-realtime" id="jam-sekarang">--:--</div>
            </div>
            <div class="clock-icon"><i data-lucide="clock"></i></div>
        </div>
        <div class="gps-rows">
            <div class="gps-row">
                <div class="gps-row-icon green"><i data-lucide="radio"></i></div>
                <span class="gps-row-label">Status GPS</span>
                <span class="gps-badge detecting" id="gps-badge">Mendeteksi...</span>
            </div>
            <div class="gps-row">
                <div class="gps-row-icon blue"><i data-lucide="map-pin"></i></div>
                <span class="gps-row-label">Lokasi Saat Ini</span>
                <span class="gps-row-value blue">{{ $lokasiKerja->nama_lokasi ?? 'Kantor Pusat' }}</span>
            </div>
            <div class="gps-row">
                <div class="gps-row-icon purple"><i data-lucide="ruler"></i></div>
                <span class="gps-row-label">Jarak dari Lokasi Kerja</span>
                <span class="gps-row-value orange" id="jarak-meter">Mengukur...</span>
            </div>
            <div class="gps-row">
                <div class="gps-row-icon green"><i data-lucide="check-circle"></i></div>
                <span class="gps-row-label">Status Hari Ini</span>
                <span class="gps-row-value green">{{ $absensiHariIni->status ?? 'Belum Absen' }}</span>
            </div>
            <div class="gps-row">
                <div class="gps-row-icon {{ $modeHariIni === 'WFA' ? 'blue' : 'green' }}"><i data-lucide="{{ $modeHariIni === 'WFA' ? 'laptop' : 'building-2' }}"></i></div>
                <span class="gps-row-label">Mode Kerja Hari Ini</span>
                <span class="gps-row-value {{ $modeHariIni === 'WFA' ? 'blue' : 'green' }}">
                    {{ $modeHariIni }}
                    @if($modeHariIni === 'WFA') (Remote) @else (Di Kantor) @endif
                </span>
            </div>
            @if($jadwalModeHariIni?->keterangan)
            <div class="gps-row">
                <div class="gps-row-icon orange"><i data-lucide="info"></i></div>
                <span class="gps-row-label">Keterangan</span>
                <span class="gps-row-value" style="color:var(--gray);font-size:11px;">{{ $jadwalModeHariIni->keterangan }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- CHECK IN / OUT --}}
    <div class="checkin-card">
        <button type="button" class="checkin-btn in" id="btn-masuk"
            {{ isset($absensiHariIni) && $absensiHariIni->jam_masuk ? 'disabled data-sudah-masuk' : 'disabled' }}>
            <i data-lucide="log-in"></i>
            Check-In
            @if(isset($absensiHariIni) && $absensiHariIni->jam_masuk)
            <small style="font-size:11px;font-weight:400;opacity:0.85;">
                {{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }}
            </small>
            @endif
        </button>
        <button type="button" class="checkin-btn out" id="btn-pulang"
            {{ !isset($absensiHariIni) || !$absensiHariIni->jam_masuk || $absensiHariIni->jam_pulang ? 'disabled' : '' }}
            {{ isset($absensiHariIni) && $absensiHariIni->jam_pulang ? 'data-sudah-pulang' : '' }}>
            <i data-lucide="log-out"></i>
            Check-Out
            @if(isset($absensiHariIni) && $absensiHariIni->jam_pulang)
            <small style="font-size:11px;font-weight:400;opacity:0.85;">
                {{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i') }}
            </small>
            @endif
        </button>
    </div>
    <div class="gps-info-box" id="gpsInfoBox">
        Tombol Check-In aktif saat Anda berada dalam area kantor
    </div>

    {{-- RINGKASAN BULAN INI --}}
    <div class="card stats-card">
        <div class="card-title-row">
            <span class="card-title">Ringkasan Bulan Ini</span>
            <span class="month-badge">{{ now()->translatedFormat('F Y') }}</span>
        </div>
        <div class="stats-grid">
            <div class="stat-item green">
                <div class="stat-num">{{ $totalHadir ?? 0 }}</div>
                <div class="stat-label">Hari Hadir</div>
            </div>
            <div class="stat-item yellow">
                <div class="stat-num">{{ $totalTerlambat ?? 0 }}</div>
                <div class="stat-label">Terlambat</div>
            </div>
            <div class="stat-item red">
                <div class="stat-num">{{ $totalAlfa ?? 0 }}</div>
                <div class="stat-label">Tidak Hadir</div>
            </div>
        </div>
        <div class="progress-wrap">
            <div class="progress-label">
                <span>Persentase Kehadiran</span>
                <span>{{ $persentaseHadir ?? 0 }}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $persentaseHadir ?? 0 }}%"></div>
            </div>
        </div>
    </div>

    {{-- GRAFIK 6 BULAN --}}
    <div class="card chart-card">
        <div class="card-title-row">
            <span class="card-title">Tren Kehadiran</span>
            <span class="month-badge">6 Bulan Terakhir</span>
        </div>
        <div class="chart-wrap">
            <canvas id="grafikKehadiran"></canvas>
        </div>
    </div>

    {{-- RIWAYAT TERBARU --}}
    <div class="card riwayat-card">
        <div class="card-title-row">
            <span class="card-title">Riwayat Terbaru</span>
            <a href="{{ route('riwayat') }}" class="riwayat-link">Lihat Semua →</a>
        </div>
        <div class="riwayat-list">
            @forelse($riwayatTerbaru ?? [] as $item)
            <div class="riwayat-item">
                <div class="riwayat-dot {{ strtolower($item->status) }}"></div>
                <div class="riwayat-info">
                    <div class="riwayat-tanggal">
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                    </div>
                    <div class="riwayat-jam">
                        Masuk: {{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}
                        &nbsp;·&nbsp;
                        Pulang: {{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}
                        @if($item->jarak_meter)
                        &nbsp;·&nbsp; {{ number_format($item->jarak_meter) }} m
                        @endif
                    </div>
                </div>
                <div class="riwayat-right">
                    <span class="riwayat-status {{ strtolower($item->status) }}">
                        {{ ucfirst(strtolower($item->status)) }}
                    </span>
                    @if(isset($item->mode_kerja) && $item->mode_kerja === 'WFA')
                    <span class="mode-badge"><i data-lucide="laptop"></i> WFA</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <div class="empty-state-title">Belum ada riwayat</div>
                <div class="empty-state-sub">Mulai absensi hari ini untuk melihat riwayat</div>
            </div>
            @endforelse
        </div>
    </div>

</main>

<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="active">
        <i data-lucide="home"></i>Dashboard
    </a>
    <a href="{{ route('riwayat') }}">
        <i data-lucide="clock"></i>Riwayat
    </a>
    <a href="{{ route('izin.index') }}">
        <i data-lucide="file-text"></i>Izin
    </a>
    <a href="{{ route('profil') }}">
        <i data-lucide="user"></i>Profil
    </a>
</nav>

<script>
    lucide.createIcons();

    function updateTime() {
        var now = new Date();
        document.getElementById('jam-sekarang').textContent =
            String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
        var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        document.getElementById('tanggal-hari').textContent =
            hari[now.getDay()] + ', ' + now.getDate() + ' ' + bulan[now.getMonth()] + ' ' + now.getFullYear();
    }
    updateTime();
    setInterval(updateTime, 1000);

    var kantorLat    = parseFloat("{{ $lokasiKerja->latitude ?? 0 }}");
    var kantorLng    = parseFloat("{{ $lokasiKerja->longitude ?? 0 }}");
    var kantorRadius = parseFloat("{{ $lokasiKerja->radius_meter ?? 100 }}");
    var userLat = null, userLng = null;

    // Mode ditentukan admin, bukan karyawan
    var modeWFA = {{ $modeHariIni === 'WFA' ? 'true' : 'false' }};

    // Jam masuk & pulang
    var jamMasukStr  = "{{ $jamMasuk ?? '' }}";
    var jamPulangStr = "{{ $jamPulang ?? '' }}";

    function jamKeMenit(str) {
        if (!str) return null;
        var parts = str.split(':');
        return parseInt(parts[0]) * 60 + parseInt(parts[1]);
    }

    function menitSekarang() {
        var now = new Date();
        return now.getHours() * 60 + now.getMinutes();
    }

    function cekRestriksiWaktu() {
        var sekarang = menitSekarang();
        var btnMasuk  = document.getElementById('btn-masuk');
        var btnPulang = document.getElementById('btn-pulang');
        var infoBox   = document.getElementById('gpsInfoBox');

        // Lock check-in jika sudah melewati jam masuk
        if (jamMasukStr && !btnMasuk.hasAttribute('data-sudah-masuk')) {
            var batasMasuk = jamKeMenit(jamMasukStr);
            if (sekarang > batasMasuk) {
                btnMasuk.disabled = true;
                btnMasuk.style.opacity = '0.4';
                btnMasuk.style.cursor = 'not-allowed';
                if (infoBox) { infoBox.textContent = 'Jam masuk (' + jamMasukStr + ') sudah terlewat. Anda terhitung Alfa hari ini.'; infoBox.classList.add('show'); }
                return false; // tidak boleh check-in
            }
        }

        // Lock check-out jika belum mencapai jam pulang
        if (jamPulangStr && btnPulang && !btnPulang.hasAttribute('data-sudah-pulang')) {
            var batasPulang = jamKeMenit(jamPulangStr);
            if (sekarang < batasPulang) {
                btnPulang.disabled = true;
                btnPulang.style.opacity = '0.4';
                btnPulang.style.cursor = 'not-allowed';
                btnPulang.title = 'Check-out mulai pukul ' + jamPulangStr;
            }
        }

        return true;
    }

    cekRestriksiWaktu();
    setInterval(cekRestriksiWaktu, 60000);

    function hitungJarak(lat1, lon1, lat2, lon2) {
        var R = 6371000;
        var dLat = (lat2-lat1)*Math.PI/180;
        var dLon = (lon2-lon1)*Math.PI/180;
        var a = Math.sin(dLat/2)*Math.sin(dLat/2) +
            Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*
            Math.sin(dLon/2)*Math.sin(dLon/2);
        return R*2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a));
    }

    function updateTombolAbsen(aktif) {
        var btnMasuk = document.getElementById('btn-masuk');
        var infoBox  = document.getElementById('gpsInfoBox');
        if (!btnMasuk) return;
        if (btnMasuk.hasAttribute('data-sudah-masuk')) return;
        if (aktif) {
            btnMasuk.disabled = false;
            btnMasuk.style.opacity = '1';
            btnMasuk.style.cursor = 'pointer';
            if (infoBox) infoBox.classList.remove('show');
        } else {
            btnMasuk.disabled = true;
            btnMasuk.style.opacity = '0.4';
            btnMasuk.style.cursor = 'not-allowed';
            if (infoBox) infoBox.classList.add('show');
        }
    }

    if (navigator.geolocation) {
        updateTombolAbsen(modeWFA);
        navigator.geolocation.watchPosition(
            function(pos) {
                userLat = pos.coords.latitude;
                userLng = pos.coords.longitude;
                var jarak  = Math.round(hitungJarak(userLat, userLng, kantorLat, kantorLng));
                var didalam = jarak <= kantorRadius;
                document.getElementById('jarak-meter').textContent = jarak + ' meter';
                var badge = document.getElementById('gps-badge');
                if (modeWFA) {
                    badge.textContent = 'Mode WFA Aktif';
                    badge.className = 'gps-badge inside';
                    updateTombolAbsen(true);
                } else if (didalam) {
                    badge.textContent = 'Di Dalam Area Kerja';
                    badge.className = 'gps-badge inside';
                    updateTombolAbsen(true);
                } else {
                    badge.textContent = 'Di Luar Area Kerja';
                    badge.className = 'gps-badge outside';
                    updateTombolAbsen(false);
                }
            },
            function(err) {
                document.getElementById('gps-badge').textContent = 'GPS Tidak Aktif';
                document.getElementById('gps-badge').className = 'gps-badge outside';
                document.getElementById('jarak-meter').textContent = 'Tidak terdeteksi';
                updateTombolAbsen(modeWFA);
                if (!modeWFA) showToast('Aktifkan GPS untuk absen WFO!', 'warning');
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        showToast('Browser tidak mendukung GPS!', 'error');
        updateTombolAbsen(modeWFA);
    }

    function showToast(message, type) {
        type = type || 'success';
        var wrap = document.getElementById('toastWrap');
        var toast = document.createElement('div');
        toast.className = 'toast ' + type;
        toast.innerHTML = '<span>' + message + '</span><button class="toast-close" onclick="this.parentElement.remove()">×</button>';
        wrap.appendChild(toast);
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(function() { toast.remove(); }, 300);
        }, 4000);
    }

    function setLoading(btn, loading) {
        if (loading) {
            btn.dataset.original = btn.innerHTML;
            btn.innerHTML = 'Memproses...';
            btn.disabled = true;
        } else {
            btn.innerHTML = btn.dataset.original;
            btn.disabled = false;
            lucide.createIcons();
        }
    }

    // ── GRAFIK KEHADIRAN ──
    (function() {
        var ctx = document.getElementById('grafikKehadiran').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($grafikLabels) !!},
                datasets: [
                    {
                        label: 'Hadir',
                        data: {!! json_encode($grafikHadir) !!},
                        backgroundColor: 'rgba(34,197,94,0.85)',
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Terlambat',
                        data: {!! json_encode($grafikTerlambat) !!},
                        backgroundColor: 'rgba(245,158,11,0.85)',
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Alfa',
                        data: {!! json_encode($grafikAlfa) !!},
                        backgroundColor: 'rgba(239,68,68,0.85)',
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Plus Jakarta Sans', size: 11 }, boxWidth: 10, padding: 12 }
                    },
                    tooltip: { bodyFont: { family: 'Plus Jakarta Sans' }, titleFont: { family: 'Plus Jakarta Sans' } }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { family: 'Plus Jakarta Sans', size: 10 } },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    }
                }
            }
        });
    })();

    document.getElementById('btn-masuk').addEventListener('click', async function() {
        if (!userLat || !userLng) { showToast('GPS belum terdeteksi. Aktifkan lokasi!', 'error'); return; }
        var modeLabel = modeWFA ? 'WFA (Remote)' : 'WFO (Di Kantor)';
        if (!confirm('Absen dengan mode: ' + modeLabel + '\n\nLanjutkan?')) return;
        var btn = this;
        setLoading(btn, true);
        try {
            var res = await fetch('{{ route("absen.masuk") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ latitude: userLat, longitude: userLng })
            });
            var data = await res.json();
            if (res.ok) {
                showToast(data.message, 'success');
                setTimeout(function() { location.reload(); }, 1500);
            } else { showToast(data.message, 'error'); setLoading(btn, false); }
        } catch(e) { showToast('Terjadi kesalahan. Coba lagi!', 'error'); setLoading(btn, false); }
    });

    document.getElementById('btn-pulang').addEventListener('click', async function() {
        var btn = this;
        setLoading(btn, true);
        try {
            var res = await fetch('{{ route("absen.pulang") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ latitude: userLat, longitude: userLng })
            });
            var data = await res.json();
            if (res.ok) {
                showToast(data.message, 'success');
                setTimeout(function() { location.reload(); }, 1500);
            } else { showToast(data.message, 'error'); setLoading(btn, false); }
        } catch(e) { showToast('Terjadi kesalahan. Coba lagi!', 'error'); setLoading(btn, false); }
    });
</script>

</body>
</html>
