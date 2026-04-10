<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – Presenly</title>
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
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #22c55e;
            --green-dark: #16a34a;
            --green-light: #dcfce7;
            --dark: #0f172a;
            --gray: #64748b;
            --gray-light: #f8fafc;
            --white: #ffffff;
            --text: #1e293b;
            --border: #e2e8f0;
            --input-bg: #f8fafc;
        }

        html { scroll-behavior: smooth; }

        body {
            background: #0f172a;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative background shapes */
        body::before {
            content: '';
            position: fixed;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(34,197,94,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -200px; left: -200px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 560px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,0.4);
            position: relative;
            z-index: 1;
            animation: fadeUp 0.5s ease both;
        }

        /* Left panel */
        .login-left {
            flex: 1;
            background: linear-gradient(145deg, #16a34a 0%, #22c55e 50%, #4ade80 100%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 280px; height: 280px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        .left-logo { display: flex; align-items: center; gap: 10px; position: relative; z-index: 1; }
        .left-logo-icon { width: 38px; height: 38px; background: rgba(255,255,255,0.25); backdrop-filter: blur(8px); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px; color: white; }
        .left-logo-text { font-size: 20px; font-weight: 800; color: white; letter-spacing: -0.4px; }
        .left-content { position: relative; z-index: 1; }
        .left-title { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; line-height: 1.2; margin-bottom: 12px; }
        .left-sub { font-size: 14px; color: rgba(255,255,255,0.85); line-height: 1.6; }
        .left-features { display: flex; flex-direction: column; gap: 10px; position: relative; z-index: 1; }
        .left-feature { display: flex; align-items: center; gap: 10px; }
        .left-feature-dot { width: 22px; height: 22px; background: rgba(255,255,255,0.25); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .left-feature-dot svg { width: 12px; height: 12px; color: white; stroke: white; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
        .left-feature-text { font-size: 13px; color: rgba(255,255,255,0.9); font-weight: 500; }

        /* Right panel */
        .login-right {
            flex: 1;
            background: var(--white);
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ── LOGO (mobile fallback) ── */
        .logo-wrap {
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            animation: fadeUp 0.5s ease both;
        }

        .logo-circle {
            width: 80px; height: 80px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(34,197,94,0.2);
        }

        .logo-circle img {
            width: 100%; height: 100%;
            object-fit: cover;
        }

        /* ── CARD ── */
        .card {
            background: transparent;
            border: none;
            border-radius: 0;
            padding: 0;
            width: 100%;
            max-width: 100%;
            box-shadow: none;
            animation: none;
        }

        .card-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.4px;
            margin-bottom: 6px;
        }

        .card-sub {
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 28px;
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px 11px 40px;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .form-control::placeholder { color: #94a3b8; }

        .form-control:focus {
            border-color: var(--green);
            background: #f0fdf4;
            box-shadow: 0 0 0 3px rgba(34,197,94,0.1);
        }

        .form-control.no-icon {
            padding-left: 14px;
        }

        /* Password toggle */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray);
            padding: 0;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }
        .toggle-pw:hover { color: var(--text); }

        /* ── REMEMBER + LUPA ── */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-wrap input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--green);
            cursor: pointer;
        }

        .remember-wrap span {
            font-size: 13px;
            color: var(--text);
            font-weight: 500;
        }

        .lupa-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--green);
            text-decoration: none;
            transition: color 0.2s;
        }
        .lupa-link:hover { color: var(--green-dark); }

        /* ── SUBMIT ── */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 20px;
            box-shadow: 0 4px 16px rgba(34,197,94,0.3);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(34,197,94,0.4);
        }

        /* ── DIVIDER ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            font-size: 12px;
            color: var(--gray);
        }

        /* ── BOTTOM TEXT ── */
        .bottom-text {
            text-align: center;
            font-size: 13px;
            color: var(--gray);
        }

        .bottom-text a {
            color: var(--green);
            font-weight: 700;
            text-decoration: none;
        }

        .bottom-text a:hover { color: var(--green-dark); }

        /* ── ERROR ── */
        .error-list {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 18px;
            list-style: none;
        }

        .error-list li {
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 2px;
        }

        .error-list li:last-child { margin-bottom: 0; }

        /* ── BACK LINK ── */
        .back-link {
            display: block;
            margin-top: 20px;
            font-size: 13px;
            color: var(--gray);
            text-decoration: none;
            transition: color 0.2s;
            text-align: center;
        }
        .back-link:hover { color: var(--text); }

        /* ── SESSION STATUS ── */
        .session-status {
            background: var(--green-light);
            border: 1px solid rgba(34,197,94,0.3);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--green-dark);
            font-weight: 500;
            margin-bottom: 16px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 700px) {
            .login-left { display: none; }
            .login-wrapper { max-width: 440px; border-radius: 20px; }
            .login-right { padding: 36px 28px; }
            body { background: var(--white); }
            body::before, body::after { display: none; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- LEFT PANEL -->
    <div class="login-left">
        <div class="left-logo">
            <div class="left-logo-icon">P</div>
            <span class="left-logo-text">Presenly</span>
        </div>
        <div class="left-content">
            <div class="left-title">Sistem Absensi<br>Modern & Cerdas</div>
            <div class="left-sub">Pantau kehadiran karyawan secara akurat menggunakan GPS real-time dan laporan otomatis.</div>
        </div>
        <div class="left-features">
            <div class="left-feature">
                <div class="left-feature-dot"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg></div>
                <span class="left-feature-text">Deteksi lokasi GPS real-time</span>
            </div>
            <div class="left-feature">
                <div class="left-feature-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                <span class="left-feature-text">Rekap kehadiran otomatis</span>
            </div>
            <div class="left-feature">
                <div class="left-feature-dot"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
                <span class="left-feature-text">Notifikasi izin real-time</span>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="login-right">
    <!-- CARD -->
    <div class="card">
        <div class="card-title">Selamat Datang</div>
        <div class="card-sub">Masuk untuk melanjutkan ke dashboard absensi</div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </span>
                    <input type="email"
                           id="email"
                           name="email"
                           class="form-control"
                           placeholder="nama@perusahaan.com"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="username">
                </div>
            </div>

            {{-- Kata Sandi --}}
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control"
                           placeholder="Masukkan kata sandi"
                           required autocomplete="current-password">
                    <button type="button" class="toggle-pw" onclick="togglePassword()" id="togglePwBtn">
                        <svg id="iconEye" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg id="iconEyeOff" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            {{-- Remember + Lupa --}}
            <div class="form-row">
                <label class="remember-wrap">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span>Ingat Saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="lupa-link">Lupa Kata Sandi?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">MASUK</button>

            <div class="divider"><span>atau</span></div>

            <div class="bottom-text">
                Belum Punya Akun? <a href="#">Hubungi HR</a>
            </div>
        </form>
    </div>

    <a href="{{ route('home') }}" class="back-link">← Kembali ke Beranda</a>
    </div><!-- end login-right -->
    </div><!-- end login-wrapper -->

    <script>
        function togglePassword() {
            const input   = document.getElementById('password');
            const iconEye    = document.getElementById('iconEye');
            const iconEyeOff = document.getElementById('iconEyeOff');
            if (input.type === 'password') {
                input.type = 'text';
                iconEye.style.display    = 'none';
                iconEyeOff.style.display = '';
            } else {
                input.type = 'password';
                iconEye.style.display    = '';
                iconEyeOff.style.display = 'none';
            }
        }
    </script>

</body>
</html>