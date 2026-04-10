<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi – {{ $user->name }} – {{ $namaBulan }} {{ $tahun }}</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #fff;
            padding: 32px 40px;
        }

        /* HEADER */
        .doc-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding-bottom: 20px;
            border-bottom: 2px solid #22c55e;
            margin-bottom: 24px;
        }
        .brand { display: flex; align-items: center; gap: 10px; }
        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 800; color: white;
        }
        .brand-name { font-size: 20px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; }
        .brand-sub { font-size: 11px; color: #64748b; margin-top: 1px; }
        .doc-meta { text-align: right; }
        .doc-meta-title { font-size: 15px; font-weight: 700; color: #0f172a; }
        .doc-meta-period {
            display: inline-block;
            margin-top: 4px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            font-size: 11px; font-weight: 700;
            padding: 2px 10px; border-radius: 20px;
        }
        .doc-meta-date { font-size: 10px; color: #94a3b8; margin-top: 4px; }

        /* EMPLOYEE INFO */
        .employee-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            gap: 40px;
        }
        .emp-row { display: flex; flex-direction: column; gap: 2px; }
        .emp-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; font-weight: 600; }
        .emp-value { font-size: 13px; font-weight: 700; color: #1e293b; }

        /* SUMMARY STATS */
        .stats-row {
            display: flex;
            gap: 12px;
            margin-bottom: 22px;
        }
        .stat-box {
            flex: 1;
            border-radius: 10px;
            padding: 12px 14px;
            text-align: center;
        }
        .stat-box.green  { background: #f0fdf4; border: 1.5px solid #bbf7d0; }
        .stat-box.yellow { background: #fffbeb; border: 1.5px solid #fde68a; }
        .stat-box.red    { background: #fef2f2; border: 1.5px solid #fecaca; }
        .stat-box.blue   { background: #eff6ff; border: 1.5px solid #bfdbfe; }
        .stat-num {
            font-size: 24px; font-weight: 800; line-height: 1;
        }
        .stat-box.green  .stat-num { color: #16a34a; }
        .stat-box.yellow .stat-num { color: #b45309; }
        .stat-box.red    .stat-num { color: #dc2626; }
        .stat-box.blue   .stat-num { color: #1d4ed8; }
        .stat-label { font-size: 10px; color: #64748b; font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.4px; }

        /* TABLE */
        .section-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.8px; color: #64748b;
            margin-bottom: 10px;
        }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #0f172a;
            color: rgba(255,255,255,0.85);
            padding: 9px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        thead th:first-child { border-radius: 8px 0 0 0; }
        thead th:last-child  { border-radius: 0 8px 0 0; }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:last-child { border-bottom: 2px solid #e2e8f0; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 8px 12px; font-size: 11px; }
        .td-no    { color: #94a3b8; text-align: center; width: 32px; }
        .td-day   { color: #64748b; }
        .td-masuk { color: #16a34a; font-weight: 700; }
        .td-muted { color: #64748b; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }
        .badge-hadir     { background: #dcfce7; color: #15803d; }
        .badge-terlambat { background: #fef3c7; color: #92400e; }
        .badge-alfa      { background: #fee2e2; color: #b91c1c; }
        .badge-izin      { background: #dbeafe; color: #1d4ed8; }

        /* FOOTER */
        .doc-footer {
            margin-top: 28px;
            padding-top: 14px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .footer-note { font-size: 10px; color: #94a3b8; }
        .ttd-box { text-align: center; }
        .ttd-label { font-size: 10px; color: #64748b; margin-bottom: 48px; }
        .ttd-line { border-top: 1px solid #1e293b; width: 160px; margin: 0 auto 4px; }
        .ttd-name { font-size: 11px; font-weight: 700; color: #1e293b; }
        .ttd-role { font-size: 10px; color: #64748b; }

        /* NO-DATA */
        .no-data { text-align: center; padding: 36px; color: #94a3b8; font-size: 12px; }

        /* PRINT */
        @media print {
            body { padding: 20px 24px; }
            .no-print { display: none !important; }
            @page { margin: 1cm; size: A4 portrait; }
        }

        /* PRINT BUTTON (screen only) */
        .print-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: #0f172a;
            color: white;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }
        .print-bar-info { font-size: 12px; color: rgba(255,255,255,0.7); }
        .print-bar-actions { display: flex; gap: 10px; }
        .btn-print {
            padding: 7px 18px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white; border: none; border-radius: 8px;
            font-size: 12px; font-weight: 700; cursor: pointer;
        }
        .btn-back {
            padding: 7px 16px;
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.8);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            text-decoration: none;
        }
        @media print { .print-bar { display: none; } }
        .print-spacer { height: 48px; }
        @media print { .print-spacer { display: none; } }
    </style>
</head>
<body>

<!-- Print Bar (screen only) -->
<div class="print-bar no-print">
    <span class="print-bar-info">Rekap Absensi – {{ $user->name }} – {{ $namaBulan }} {{ $tahun }}</span>
    <div class="print-bar-actions">
        <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>
</div>
<div class="print-spacer"></div>

<!-- HEADER -->
<div class="doc-header">
    <div class="brand">
        <div class="brand-icon">P</div>
        <div>
            <div class="brand-name">Presenly</div>
            <div class="brand-sub">Sistem Absensi Karyawan</div>
        </div>
    </div>
    <div class="doc-meta">
        <div class="doc-meta-title">Rekap Kehadiran Bulanan</div>
        <div class="doc-meta-period">{{ $namaBulan }} {{ $tahun }}</div>
        <div class="doc-meta-date">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</div>
    </div>
</div>

<!-- EMPLOYEE INFO -->
<div class="employee-box">
    <div class="emp-row">
        <span class="emp-label">Nama Karyawan</span>
        <span class="emp-value">{{ $user->name }}</span>
    </div>
    <div class="emp-row">
        <span class="emp-label">Email</span>
        <span class="emp-value">{{ $user->email }}</span>
    </div>
    <div class="emp-row">
        <span class="emp-label">Periode</span>
        <span class="emp-value">{{ $namaBulan }} {{ $tahun }}</span>
    </div>
    <div class="emp-row">
        <span class="emp-label">Total Hari Kerja</span>
        <span class="emp-value">{{ $riwayat->count() }} hari</span>
    </div>
</div>

<!-- STATS -->
@php
    $totalHadir     = $riwayat->where('status', 'Hadir')->count();
    $totalTerlambat = $riwayat->where('status', 'Terlambat')->count();
    $totalAlfa      = $riwayat->where('status', 'Alfa')->count();
    $totalIzin      = $riwayat->where('status', 'Izin')->count();
@endphp
<div class="stats-row">
    <div class="stat-box green">
        <div class="stat-num">{{ $totalHadir }}</div>
        <div class="stat-label">Hadir Tepat Waktu</div>
    </div>
    <div class="stat-box yellow">
        <div class="stat-num">{{ $totalTerlambat }}</div>
        <div class="stat-label">Terlambat</div>
    </div>
    <div class="stat-box red">
        <div class="stat-num">{{ $totalAlfa }}</div>
        <div class="stat-label">Alfa</div>
    </div>
    <div class="stat-box blue">
        <div class="stat-num">{{ $totalIzin }}</div>
        <div class="stat-label">Izin</div>
    </div>
</div>

<!-- TABLE -->
<div class="section-title">Detail Kehadiran</div>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Hari</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Durasi Kerja</th>
            <th>Jarak</th>
            <th>Mode</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayat as $i => $item)
        <tr>
            <td class="td-no">{{ $i + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
            <td class="td-day">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</td>
            <td class="td-masuk">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
            <td class="td-muted">{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
            <td class="td-muted">{{ $item->durasi_kerja ?? '-' }}</td>
            <td class="td-muted">{{ $item->jarak_meter ? number_format($item->jarak_meter, 0) . ' m' : '-' }}</td>
            <td class="td-muted">{{ $item->mode_kerja ?? 'WFO' }}</td>
            <td>
                @php $st = $item->status ?? '-'; @endphp
                <span class="badge badge-{{ strtolower($st) }}">{{ $st }}</span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="no-data">Tidak ada data absensi pada periode ini</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- FOOTER -->
<div class="doc-footer">
    <div class="footer-note">
        Dokumen ini digenerate otomatis oleh sistem Presenly.<br>
        Dicetak pada {{ now()->translatedFormat('d F Y') }} pukul {{ now()->format('H:i') }} WIB.
    </div>
    <div class="ttd-box">
        <div class="ttd-label">Mengetahui, HRD/Atasan</div>
        <div class="ttd-line"></div>
        <div class="ttd-name">( _________________________ )</div>
        <div class="ttd-role">Jabatan</div>
    </div>
</div>

<script>
    // Auto-open print dialog when opened directly (not via back navigation)
    if (!document.referrer || !window.history.length) {
        window.addEventListener('load', function() { window.print(); });
    }
</script>
</body>
</html>
