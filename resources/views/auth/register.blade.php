<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
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
            background: var(--white);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* ── LOGO ── */
        .logo-wrap {
            display: flex;
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
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            animation: fadeUp 0.5s 0.05s ease both;
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

        .input-wrap { position: relative; }

        .form-control {
            width: 100%;
            padding: 11px 14px;
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
            font-size: 16px;
            padding: 0;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--text); }

        /* ── SUBMIT ── */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--green);
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
        }

        .btn-submit:hover {
            background: var(--green-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(34,197,94,0.3);
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

        .divider span { font-size: 12px; color: var(--gray); }

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
            margin-top: 24px;
            font-size: 13px;
            color: var(--gray);
            text-decoration: none;
            transition: color 0.2s;
            animation: fadeUp 0.5s 0.1s ease both;
        }
        .back-link:hover { color: var(--text); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .card { padding: 28px 24px; }
        }
    </style>
</head>
<body>

    <!-- LOGO -->
    <div class="logo-wrap">
        <div class="logo-circle">
            <img src="{{ asset('images/logo_presenly.png') }}" alt="Presenly"
                 onerror="this.parentElement.style.background='#22c55e';this.style.display='none';this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:white;\'>P</div>'">
        </div>
    </div>

    <!-- CARD -->
    <div class="card">
        <div class="card-title">Buat Akun Baru</div>
        <div class="card-sub">Daftarkan diri untuk menggunakan Presenly</div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text"
                       id="name"
                       name="name"
                       class="form-control"
                       placeholder="Nama lengkap Anda"
                       value="{{ old('name') }}"
                       required autofocus autocomplete="name">
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="nama@perusahaan.com"
                       value="{{ old('email') }}"
                       required autocomplete="username">
            </div>

            {{-- Kata Sandi --}}
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-wrap">
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control"
                           style="padding-right: 44px;"
                           placeholder="Min. 8 karakter"
                           required autocomplete="new-password">
                    <button type="button" class="toggle-pw" onclick="togglePassword('password', 'togglePw1')" id="togglePw1">👁️</button>
                </div>
            </div>

            {{-- Konfirmasi Kata Sandi --}}
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                <div class="input-wrap">
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="form-control"
                           style="padding-right: 44px;"
                           placeholder="Ulangi kata sandi"
                           required autocomplete="new-password">
                    <button type="button" class="toggle-pw" onclick="togglePassword('password_confirmation', 'togglePw2')" id="togglePw2">👁️</button>
                </div>
            </div>

            <button type="submit" class="btn-submit">DAFTAR</button>

            <div class="divider"><span>atau</span></div>

            <div class="bottom-text">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </form>
    </div>

    <a href="{{ route('login') }}" class="back-link">← Kembali ke Halaman Masuk</a>

    <script>
        function togglePassword(fieldId, btnId) {
            const input = document.getElementById(fieldId);
            const btn   = document.getElementById(btnId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁️';
            }
        }
    </script>

</body>
</html>
