<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi – Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-light: #dcfce7;
            --dark: #0f172a; --gray: #64748b; --white: #ffffff;
            --text: #1e293b; --border: #e2e8f0; --input-bg: #f8fafc;
        }
        body {
            background: #0f172a;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: -200px; left: 50%; transform: translateX(-50%);
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(34,197,94,0.1) 0%, transparent 65%);
            pointer-events: none;
        }

        .logo-wrap {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 32px;
            animation: fadeUp 0.5s ease both;
            position: relative; z-index: 1;
        }
        .logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 17px; color: white; box-shadow: 0 4px 14px rgba(34,197,94,0.4); }
        .logo-text { font-size: 20px; font-weight: 800; color: white; letter-spacing: -0.4px; }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.35);
            animation: fadeUp 0.5s 0.05s ease both;
            position: relative; z-index: 1;
        }

        .card-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
        }
        .card-icon svg { width: 26px; height: 26px; stroke: #16a34a; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .card-title { font-size: 22px; font-weight: 800; color: var(--dark); letter-spacing: -0.4px; margin-bottom: 6px; }
        .card-sub { font-size: 13px; color: var(--gray); margin-bottom: 24px; line-height: 1.6; }

        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 7px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--gray); pointer-events: none; display: flex; align-items: center; }
        .input-icon svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .form-control { width: 100%; padding: 11px 14px 11px 40px; background: var(--input-bg); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; outline: none; transition: all 0.2s; }
        .form-control::placeholder { color: #94a3b8; }
        .form-control:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }

        .btn-submit { width: 100%; padding: 13px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; letter-spacing: 0.3px; cursor: pointer; transition: all 0.2s; margin-top: 4px; box-shadow: 0 4px 16px rgba(34,197,94,0.3); }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(34,197,94,0.4); }

        .error-list { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; list-style: none; }
        .error-list li { font-size: 13px; color: #dc2626; }

        .session-status { background: var(--green-light); border: 1px solid rgba(34,197,94,0.3); border-radius: 10px; padding: 12px 16px; font-size: 13px; color: var(--green-dark); font-weight: 500; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .session-status svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }

        .back-link { margin-top: 20px; font-size: 13px; color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.2s; animation: fadeUp 0.5s 0.1s ease both; position: relative; z-index: 1; display: flex; align-items: center; gap: 6px; }
        .back-link:hover { color: rgba(255,255,255,0.85); }
        .back-link svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 480px) { .card { padding: 28px 24px; } }
    </style>
</head>
<body>

    <div class="logo-wrap">
        <div class="logo-icon">P</div>
        <span class="logo-text">Presenly</span>
    </div>

    <div class="card">
        <div class="card-icon">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div class="card-title">Lupa Kata Sandi?</div>
        <div class="card-sub">Masukkan email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi.</div>

        @if (session('status'))
            <div class="session-status">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <span class="input-icon"><svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="nama@perusahaan.com"
                           value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>
            </div>
            <button type="submit" class="btn-submit">Kirim Tautan Reset</button>
        </form>
    </div>

    <a href="{{ route('login') }}" class="back-link">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Halaman Masuk
    </a>

</body>
</html>
