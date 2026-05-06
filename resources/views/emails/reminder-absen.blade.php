<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Absen – Presenly</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 0;">
    <tr><td align="center">
        <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.07);">

            <!-- Header -->
            <tr>
                <td style="background:linear-gradient(135deg,#16a34a,#22c55e);padding:28px 32px;text-align:center;">
                    <div style="display:inline-block;background:rgba(255,255,255,0.2);border-radius:10px;padding:8px 14px;margin-bottom:10px;">
                        <span style="color:white;font-size:22px;font-weight:800;letter-spacing:-0.5px;">Presenly</span>
                    </div>
                    <div style="color:rgba(255,255,255,0.85);font-size:13px;margin-top:4px;">Sistem Absensi Karyawan</div>
                </td>
            </tr>

            <!-- Body -->
            <tr>
                <td style="padding:32px;">
                    <p style="font-size:15px;font-weight:700;color:#0f172a;margin:0 0 8px;">
                        Halo, {{ $user->name }}! 👋
                    </p>
                    <p style="font-size:14px;color:#475569;margin:0 0 24px;line-height:1.6;">
                        Ini adalah pengingat bahwa kamu <strong>belum absen masuk</strong> hari ini,
                        <strong>{{ now()->translatedFormat('l, d F Y') }}</strong>.
                    </p>

                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:16px 20px;margin-bottom:24px;">
                        <p style="font-size:13px;color:#15803d;margin:0;font-weight:600;">
                            ⏰ Jangan sampai terlambat atau termark Alfa!
                        </p>
                        <p style="font-size:12px;color:#16a34a;margin:6px 0 0;">
                            Segera lakukan absen masuk melalui aplikasi Presenly.
                        </p>
                    </div>

                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center">
                                <a href="{{ config('app.url') }}/dashboard"
                                   style="display:inline-block;background:linear-gradient(135deg,#16a34a,#22c55e);color:white;text-decoration:none;padding:13px 32px;border-radius:10px;font-size:14px;font-weight:700;letter-spacing:0.2px;">
                                    Absen Sekarang →
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td style="background:#f8fafc;padding:16px 32px;border-top:1px solid #e2e8f0;text-align:center;">
                    <p style="font-size:11px;color:#94a3b8;margin:0;">
                        Email ini dikirim otomatis oleh sistem Presenly. Jangan reply email ini.
                    </p>
                </td>
            </tr>

        </table>
    </td></tr>
</table>
</body>
</html>
