<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi – Presenly</title>
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

        .logo-wrap { display: flex; align-items: center; gap: 10px; margin-bottom: 32px; animation: fadeUp 0.5s ease both; position: relative; z-index: 1; }
        .logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 17px; color: white; box-shadow: 0 4px 14px rgba(34,197,94,0.4); }
        .logo-text { font-size: 20px; font-weight: 800; color: white; letter-spacing: -0.4px; }

        .card { background: var(--white); border: 1px solid var(--border); border-radius: 20px; padding: 36px 40px; width: 100%; max-width: 440px; box-shadow: 0 24px 64px rgba(0,0,0,0.35); animation: fadeUp 0.5s 0.05s ease both; position: relative; z-index: 1; }

        .card-icon { width: 52px; height: 52px; background: linear-gradient(135deg, #dcfce7, #bbf7d0); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
        .card-icon svg { width: 26px; height: 26px; stroke: #16a34a; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .card-title { font-size: 22px; font-weight: 800; color: var(--dark); letter-spacing: -0.4px; margin-bottom: 6px; }
        .card-sub { font-size: 13px; color: var(--gray); margin-bottom: 24px; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 7px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--gray); pointer-events: none; display: flex; align-items: center; }
        .input-icon svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .form-control { width: 100%; padding: 11px 42px 11px 40px; background: var(--input-bg); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; outline: none; transition: all 0.2s; }
        .form-control.no-icon { padding-left: 14px; padding-right: 14px; }
        .form-control::placeholder { color: #94a3b8; }
        .form-control:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }

        .toggle-pw { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--gray); padding: 0; transition: color 0.2s; display: flex; align-items: center; }
        .toggle-pw:hover { color: var(--text); }
        .toggle-pw svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .btn-submit { width: 100%; padding: 13px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; letter-spacing: 0.3px; cursor: pointer; transition: all 0.2s; margin-top: 8px; box-shadow: 0 4px 16px rgba(34,197,94,0.3); }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(34,197,94,0.4); }

        .error-list { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; list-style: none; }
        .error-list li { font-size: 13px; color: #dc2626; }

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
            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div class="card-title">Reset Kata Sandi</div>
        <div class="card-sub">Buat kata sandi baru yang kuat untuk akun Anda.</div>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <span class="input-icon"><svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="nama@perusahaan.com"
                           value="{{ old('email', $request->email) }}"
                           required autofocus autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi Baru</label>
                <div class="input-wrap">
                    <span class="input-icon"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="Minimal 8 karakter"
                           required autocomplete="new-password">
                    <button type="button" class="toggle-pw" id="togglePw1" onclick="togglePw('password','togglePw1')">
                        <svg id="eyeIcon1" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg id="eyeOffIcon1" style="display:none" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                <div class="input-wrap">
                    <span class="input-icon"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                           placeholder="Ulangi kata sandi baru"
                           required autocomplete="new-password">
                    <button type="button" class="toggle-pw" id="togglePw2" onclick="togglePw('password_confirmation','togglePw2')">
                        <svg id="eyeIcon2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg id="eyeOffIcon2" style="display:none" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">Simpan Kata Sandi Baru</button>
        </form>
    </div>

    <a href="{{ route('login') }}" class="back-link">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Halaman Masuk
    </a>

    <script>
        function togglePw(fieldId, btnId) {
            var input = document.getElementById(fieldId);
            var num = btnId.replace('togglePw','');
            var eye    = document.getElementById('eyeIcon'    + num);
            var eyeOff = document.getElementById('eyeOffIcon' + num);
            if (input.type === 'password') {
                input.type = 'text';
                eye.style.display    = 'none';
                eyeOff.style.display = '';
            } else {
                input.type = 'password';
                eye.style.display    = '';
                eyeOff.style.display = 'none';
            }
        }
    </script>
</body>
</html>
