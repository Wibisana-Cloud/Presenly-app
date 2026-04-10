<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 – Akses Ditolak | Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #0f172a;
            color: #e2e8f0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: -150px; left: 50%; transform: translateX(-50%);
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(239,68,68,0.08) 0%, transparent 65%);
            pointer-events: none;
        }
        .error-wrap { position: relative; z-index: 1; }
        .error-icon {
            width: 80px; height: 80px;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            animation: fadeUp 0.5s ease both;
        }
        .error-icon svg { width: 38px; height: 38px; stroke: #f87171; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .error-code {
            font-size: 100px;
            font-weight: 800;
            background: linear-gradient(135deg, #fca5a5, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            letter-spacing: -6px;
            margin-bottom: 20px;
            animation: fadeUp 0.5s 0.05s ease both;
        }
        .error-title {
            font-size: 24px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
            animation: fadeUp 0.5s 0.1s ease both;
        }
        .error-desc {
            font-size: 14px;
            color: #94a3b8;
            max-width: 360px;
            line-height: 1.7;
            margin: 0 auto 36px;
            animation: fadeUp 0.5s 0.15s ease both;
        }
        .btn-group { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; animation: fadeUp 0.5s 0.2s ease both; }
        .btn-home {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white; border-radius: 10px;
            font-size: 14px; font-weight: 700; text-decoration: none;
            transition: all 0.2s; box-shadow: 0 4px 16px rgba(34,197,94,0.3);
        }
        .btn-home:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(34,197,94,0.4); }
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 24px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: #cbd5e1; border-radius: 10px;
            font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
        }
        .btn-back:hover { background: rgba(255,255,255,0.12); color: white; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="error-wrap">
        <div class="error-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div class="error-code">403</div>
        <div class="error-title">Akses Ditolak</div>
        <p class="error-desc">
            Anda tidak memiliki izin untuk mengakses halaman ini.
            Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
        </p>
        <div class="btn-group">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-home">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-home">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk
                </a>
            @endauth
            <a href="javascript:history.back()" class="btn-back">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>
</body>
</html>
