<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presenly – Pantau Kehadiran Secara Real-Time & Otomatis</title>
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
            --green-mid: #bbf7d0;
            --dark: #0f172a;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --gray-mid: #e2e8f0;
            --white: #ffffff;
            --text: #1e293b;
            --border: #e2e8f0;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--white);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky;
            top: 0;
            background: rgba(15,23,42,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 0 40px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .logo-icon-nav { width: 32px; height: 32px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; color: white; box-shadow: 0 3px 10px rgba(34,197,94,0.4); }
        .logo-text-nav { font-size: 17px; font-weight: 800; color: white; letter-spacing: -0.3px; }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-outline {
            padding: 8px 20px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            background: transparent;
            color: rgba(255,255,255,0.85);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .btn-primary {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 3px 12px rgba(34,197,94,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(34,197,94,0.4);
        }

        /* ── HERO ── */
        .hero-wrap {
            background: linear-gradient(160deg, #0f172a 0%, #0d1f10 60%, #0f172a 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-wrap::before {
            content: '';
            position: absolute;
            top: -150px; right: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(34,197,94,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-wrap::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero {
            padding: 80px 40px 72px;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
            position: relative;
            z-index: 1;
        }

        .hero-left { animation: fadeUp 0.6s ease both; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            background: rgba(34,197,94,0.15);
            border: 1px solid rgba(34,197,94,0.3);
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            color: #4ade80;
            margin-bottom: 20px;
            letter-spacing: 0.3px;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 800;
            color: white;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 18px;
        }

        .hero-title span { color: #4ade80; }

        .hero-sub {
            font-size: 16px;
            color: #94a3b8;
            margin-bottom: 36px;
            line-height: 1.7;
            max-width: 440px;
        }

        .hero-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-hero-primary {
            padding: 13px 30px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(34,197,94,0.35);
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(34,197,94,0.45);
        }

        .btn-hero-outline {
            padding: 13px 28px;
            background: transparent;
            color: rgba(255,255,255,0.85);
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-hero-outline:hover {
            border-color: rgba(255,255,255,0.4);
            color: white;
        }

        /* ── HERO RIGHT ── */
        .hero-right {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeUp 0.6s 0.1s ease both;
        }

        .hero-logo-big {
            width: 280px;
            height: 280px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 24px 80px rgba(34,197,94,0.35);
        }

        .hero-logo-big img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── FEATURES ── */
        .features {
            padding: 72px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-label {
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--green-dark);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .section-title {
            text-align: center;
            font-size: 32px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }
        .section-sub {
            text-align: center;
            font-size: 15px;
            color: var(--gray);
            margin-bottom: 48px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 28px 24px;
            transition: all 0.3s;
            animation: fadeUp 0.6s ease both;
        }

        .feature-card:nth-child(1) { animation-delay: 0.05s; }
        .feature-card:nth-child(2) { animation-delay: 0.1s; }
        .feature-card:nth-child(3) { animation-delay: 0.15s; }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.08);
            border-color: var(--green-mid);
        }

        .feature-icon-wrap {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
        }
        .feature-icon-wrap.green  { background: linear-gradient(135deg, #bbf7d0, #dcfce7); }
        .feature-icon-wrap.blue   { background: linear-gradient(135deg, #bfdbfe, #dbeafe); }
        .feature-icon-wrap.purple { background: linear-gradient(135deg, #ddd6fe, #ede9fe); }
        .feature-icon-wrap svg { width: 26px; height: 26px; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .feature-icon-wrap.green  svg { stroke: #16a34a; }
        .feature-icon-wrap.blue   svg { stroke: #2563eb; }
        .feature-icon-wrap.purple svg { stroke: #7c3aed; }

        .feature-body { padding: 0; }

        .feature-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .feature-desc {
            font-size: 13px;
            color: var(--gray);
            line-height: 1.65;
        }

        /* ── TESTIMONI ── */
        .testimoni {
            padding: 0 40px 72px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimoni-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .testimoni-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            transition: all 0.2s;
            animation: fadeUp 0.6s ease both;
        }

        .testimoni-card:nth-child(1) { animation-delay: 0.05s; }
        .testimoni-card:nth-child(2) { animation-delay: 0.1s; }
        .testimoni-card:nth-child(3) { animation-delay: 0.15s; }

        .testimoni-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.07);
            border-color: var(--green-mid);
        }

        .testimoni-quote { font-size: 28px; color: var(--green); margin-bottom: 8px; line-height: 1; }

        .testimoni-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .testimoni-sub {
            font-size: 13px;
            color: var(--gray);
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .testimoni-stars {
            color: #f59e0b;
            font-size: 14px;
            margin-bottom: 12px;
            letter-spacing: 2px;
        }

        .testimoni-user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .testimoni-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .testimoni-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark);
        }

        .testimoni-role {
            font-size: 11px;
            color: var(--gray);
        }

        /* ── CTA ── */
        .cta-wrap {
            padding: 0 40px 72px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .cta {
            background: linear-gradient(135deg, #0f172a 0%, #0d2310 50%, #0f172a 100%);
            border-radius: 24px;
            padding: 64px 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(34,197,94,0.12) 0%, transparent 70%);
        }

        .cta-title {
            font-size: 36px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.8px;
            margin-bottom: 14px;
            position: relative;
        }

        .cta-title span { color: #4ade80; }

        .cta-sub {
            font-size: 15px;
            color: #94a3b8;
            margin-bottom: 32px;
            position: relative;
        }

        .btn-cta {
            display: inline-block;
            padding: 14px 36px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 6px 20px rgba(34,197,94,0.4);
            position: relative;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(34,197,94,0.5);
        }

        /* ── FOOTER ── */
        .footer {
            padding: 24px 40px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-text { font-size: 13px; color: var(--gray); }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            .navbar { padding: 0 20px; }

            .hero {
                grid-template-columns: 1fr;
                padding: 48px 20px 40px;
                gap: 36px;
                text-align: center;
            }

            .hero-title { font-size: 32px; letter-spacing: -0.8px; }
            .hero-sub { max-width: 100%; }
            .hero-buttons { justify-content: center; flex-wrap: wrap; }
            .hero-right { order: -1; }
            .hero-logo-big { width: 180px; height: 180px; }

            .features { padding: 48px 20px; }
            .features-grid { grid-template-columns: 1fr; }
            .section-title { font-size: 26px; }

            .testimoni { padding: 0 20px 48px; }
            .testimoni-grid { grid-template-columns: 1fr; }

            .cta-wrap { padding: 0 20px 48px; }
            .cta { padding: 40px 24px; }
            .cta-title { font-size: 26px; }

            .footer { flex-direction: column; gap: 8px; text-align: center; padding: 20px; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="/" class="logo">
        <div class="logo-icon-nav">P</div>
        <span class="logo-text-nav">Presenly</span>
    </a>
    <div class="nav-actions">
        <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
    </div>
</nav>

<!-- HERO -->
<div class="hero-wrap">
<section class="hero">
    <div class="hero-left">
        <div class="hero-badge">
            <svg width="7" height="7" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4" fill="currentColor"/></svg>
            Sistem Absensi Modern
        </div>
        <h1 class="hero-title">
            Pantau Kehadiran<br>
            Secara <span>Real-Time</span><br>
            &amp; Otomatis
        </h1>
        <p class="hero-sub">
            Presenly membantu perusahaan memantau kehadiran karyawan
            secara akurat menggunakan GPS, notifikasi otomatis, dan
            laporan kehadiran yang lengkap.
        </p>
        <div class="hero-buttons">
            <a href="{{ route('login') }}" class="btn-hero-primary">Mulai Sekarang →</a>
            <a href="#fitur" class="btn-hero-outline">Lihat Fitur</a>
        </div>
    </div>

    <div class="hero-right">
        <div class="hero-logo-big">
            <img src="{{ asset('images/logo_presenly.png') }}" alt="Presenly">
        </div>
    </div>
</section>
</div>

<!-- FEATURES -->
<section class="features" id="fitur">
    <div class="section-label">Fitur Utama</div>
    <h2 class="section-title">Semua yang Anda Butuhkan</h2>
    <p class="section-sub">Solusi absensi lengkap untuk perusahaan modern</p>
    <div class="features-grid">

        <div class="feature-card">
            <div class="feature-icon-wrap green">
                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
            </div>
            <div class="feature-body">
                <div class="feature-title">Deteksi Lokasi GPS</div>
                <div class="feature-desc">Sistem memverifikasi kehadiran secara otomatis menggunakan koordinat GPS yang telah ditentukan untuk memastikan absensi di lokasi yang valid.</div>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-icon-wrap blue">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div class="feature-body">
                <div class="feature-title">Notifikasi Otomatis</div>
                <div class="feature-desc">Karyawan dan admin menerima notifikasi real-time untuk absensi, pengajuan izin, dan persetujuan — tepat waktu tanpa perlu cek manual.</div>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-icon-wrap purple">
                <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div class="feature-body">
                <div class="feature-title">Rekap &amp; Laporan</div>
                <div class="feature-desc">Data absensi terekap otomatis dan dapat diekspor ke PDF atau CSV kapan saja, lengkap dengan statistik kehadiran per karyawan.</div>
            </div>
        </div>

    </div>
</section>

<!-- TESTIMONI -->
<section class="testimoni">
    <div class="section-label">Testimoni</div>
    <h2 class="section-title">Apa Kata Pengguna</h2>
    <p class="section-sub" style="margin-bottom:40px;">Dipercaya oleh berbagai tim dan perusahaan</p>
    <div class="testimoni-grid">

        <div class="testimoni-card">
            <div class="testimoni-quote">"</div>
            <div class="testimoni-label">Sangat membantu tim HR kami dalam memantau kehadiran secara akurat.</div>
            <div class="testimoni-stars">★★★★★</div>
            <div class="testimoni-user">
                <div class="testimoni-avatar">T</div>
                <div>
                    <div class="testimoni-name">Tim HR Manager</div>
                    <div class="testimoni-role">Perusahaan Manufaktur</div>
                </div>
            </div>
        </div>

        <div class="testimoni-card">
            <div class="testimoni-quote">"</div>
            <div class="testimoni-label">Check-in via GPS sangat mudah dan tidak bisa di-cheat karyawan.</div>
            <div class="testimoni-stars">★★★★★</div>
            <div class="testimoni-user">
                <div class="testimoni-avatar" style="background: linear-gradient(135deg, #2563eb, #3b82f6);">D</div>
                <div>
                    <div class="testimoni-name">Direktur Operasional</div>
                    <div class="testimoni-role">Startup Teknologi</div>
                </div>
            </div>
        </div>

        <div class="testimoni-card">
            <div class="testimoni-quote">"</div>
            <div class="testimoni-label">Laporan otomatis membuat rekap bulanan jauh lebih efisien dari sebelumnya.</div>
            <div class="testimoni-stars">★★★★★</div>
            <div class="testimoni-user">
                <div class="testimoni-avatar" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6);">F</div>
                <div>
                    <div class="testimoni-name">Finance & Admin</div>
                    <div class="testimoni-role">Perusahaan Retail</div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CTA -->
<div class="cta-wrap">
    <div class="cta">
        <h2 class="cta-title">Mulai Gunakan <span>Presenly</span> Sekarang</h2>
        <p class="cta-sub">Kelola absensi karyawan dengan mudah, akurat, dan efisien.</p>
        <a href="{{ route('register') }}" class="btn-cta">Mulai Sekarang</a>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <span class="footer-text">© 2026 Presenly. All rights reserved.</span>
    <span class="footer-text">Sistem Informasi Absensi Karyawan</span>
</footer>

</body>
</html>