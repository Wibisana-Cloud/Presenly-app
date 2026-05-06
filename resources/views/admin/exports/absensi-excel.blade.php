<html>
<head>
    <meta charset="UTF-8">
    <style>
        body  { font-family: Arial, sans-serif; font-size: 10pt; }
        table { border-collapse: collapse; }

        .title    { font-size: 14pt; font-weight: bold; color: #0f172a; padding: 4px 0; }
        .subtitle { font-size: 10pt; color: #64748b; padding: 2px 0; }

        .info-label { font-weight: bold; color: #475569; padding: 5px 16px 5px 0; white-space: nowrap; }
        .info-value { padding: 5px 24px 5px 0; color: #1e293b; }

        .stat-box { font-weight: bold; font-size: 10pt; padding: 7px 14px; white-space: nowrap; border: 1px solid #e2e8f0; }
        .stat-num { font-size: 13pt; font-weight: bold; padding: 7px 14px; text-align: center; border: 1px solid #e2e8f0; }
        .s-hadir     { background: #dcfce7; color: #15803d; }
        .s-terlambat { background: #fef9c3; color: #92400e; }
        .s-alfa      { background: #fee2e2; color: #b91c1c; }
        .s-izin      { background: #dbeafe; color: #1d4ed8; }
        .s-wfo       { background: #f0fdf4; color: #166534; }
        .s-wfa       { background: #eff6ff; color: #1e40af; }
        .s-total     { background: #f1f5f9; color: #1e293b; }

        .th { background: #1e293b; color: #ffffff; font-weight: bold; font-size: 10pt;
              padding: 8px 10px; border: 1px solid #334155; text-align: center;
              white-space: nowrap; mso-number-format: "\@"; }
        .td   { padding: 6px 10px; border: 1px solid #e2e8f0; font-size: 10pt; mso-number-format: "\@"; }
        .td-c { padding: 6px 10px; border: 1px solid #e2e8f0; font-size: 10pt; text-align: center; mso-number-format: "\@"; }
        .row-alt { background: #f8fafc; }
        .masuk { color: #16a34a; font-weight: bold; }

        .b-hadir     { background: #dcfce7; color: #15803d; font-weight: bold; text-align: center; border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }
        .b-terlambat { background: #fef9c3; color: #92400e; font-weight: bold; text-align: center; border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }
        .b-alfa      { background: #fee2e2; color: #b91c1c; font-weight: bold; text-align: center; border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }
        .b-izin      { background: #dbeafe; color: #1d4ed8; font-weight: bold; text-align: center; border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }

        .footer { font-size: 9pt; color: #94a3b8; padding-top: 10px; }
    </style>
</head>
<body>
<table>
    <colgroup>
        <col style="width: 40px;">
        <col style="width: 140px;">
        <col style="width: 175px;">
        <col style="width: 105px;">
        <col style="width: 95px;">
        <col style="width: 90px;">
        <col style="width: 90px;">
        <col style="width: 130px;">
        <col style="width: 75px;">
        <col style="width: 65px;">
        <col style="width: 105px;">
    </colgroup>

    {{-- Title --}}
    <tr><td class="title" colspan="11">Rekap Semua Absensi Karyawan</td></tr>
    <tr><td class="subtitle" colspan="11">Presenly &ndash; Sistem Absensi Karyawan</td></tr>
    <tr><td colspan="11" style="padding:3px;"></td></tr>

    {{-- Info --}}
    <tr>
        <td class="info-label" colspan="2">Periode</td>
        <td class="info-value" colspan="3">{{ $periodeLabel }}</td>
        <td class="info-label" colspan="2">Total Data</td>
        <td class="info-value" colspan="4">{{ $absensi->count() }} record</td>
    </tr>
    <tr>
        <td class="info-label" colspan="2">Dicetak</td>
        <td class="info-value" colspan="3">{{ now()->translatedFormat('d F Y, H:i') }}</td>
        <td class="info-label" colspan="2">Dicetak Oleh</td>
        <td class="info-value" colspan="4">{{ auth()->user()->name }}</td>
    </tr>
    <tr><td colspan="11" style="padding:3px;"></td></tr>

    {{-- Stats --}}
    @php
        $totalHadir     = $absensi->where('status', 'Hadir')->count();
        $totalTerlambat = $absensi->where('status', 'Terlambat')->count();
        $totalAlfa      = $absensi->where('status', 'Alfa')->count();
        $totalIzin      = $absensi->where('status', 'Izin')->count();
        $totalWFO       = $absensi->where('mode_kerja', 'WFO')->count();
        $totalWFA       = $absensi->where('mode_kerja', 'WFA')->count();
    @endphp
    <tr>
        <td class="stat-box s-hadir" colspan="2">Hadir</td>
        <td class="stat-num s-hadir">{{ $totalHadir }}</td>
        <td style="border:none;"></td>
        <td class="stat-box s-terlambat" colspan="2">Terlambat</td>
        <td class="stat-num s-terlambat">{{ $totalTerlambat }}</td>
        <td style="border:none;"></td>
        <td class="stat-box s-alfa" colspan="2">Alfa</td>
        <td class="stat-num s-alfa">{{ $totalAlfa }}</td>
    </tr>
    <tr>
        <td class="stat-box s-izin" colspan="2">Izin</td>
        <td class="stat-num s-izin">{{ $totalIzin }}</td>
        <td style="border:none;"></td>
        <td class="stat-box s-wfo" colspan="2">WFO</td>
        <td class="stat-num s-wfo">{{ $totalWFO }}</td>
        <td style="border:none;"></td>
        <td class="stat-box s-wfa" colspan="2">WFA</td>
        <td class="stat-num s-wfa">{{ $totalWFA }}</td>
    </tr>
    <tr>
        <td class="stat-box s-total" colspan="2">Total Kehadiran</td>
        <td class="stat-num s-total">{{ $absensi->count() }}</td>
        <td colspan="8" style="border:none;"></td>
    </tr>
    <tr><td colspan="11" style="padding:3px;"></td></tr>

    {{-- Table Header --}}
    <tr>
        <th class="th">No</th>
        <th class="th">Nama</th>
        <th class="th">Email</th>
        <th class="th">Tanggal</th>
        <th class="th">Hari</th>
        <th class="th">Jam Masuk</th>
        <th class="th">Jam Pulang</th>
        <th class="th">Durasi Kerja</th>
        <th class="th">Jarak (m)</th>
        <th class="th">Mode</th>
        <th class="th">Status</th>
    </tr>

    {{-- Table Body --}}
    @forelse($absensi as $i => $row)
    @php $st = strtolower($row->status ?? 'alfa'); @endphp
    <tr class="{{ $i % 2 === 1 ? 'row-alt' : '' }}">
        <td class="td-c">{{ $i + 1 }}</td>
        <td class="td">{{ $row->user->name ?? '-' }}</td>
        <td class="td">{{ $row->user->email ?? '-' }}</td>
        <td class="td">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
        <td class="td">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l') }}</td>
        <td class="td masuk">{{ $row->jam_masuk ? \Carbon\Carbon::parse($row->jam_masuk)->format('H:i') : '-' }}</td>
        <td class="td">{{ $row->jam_pulang ? \Carbon\Carbon::parse($row->jam_pulang)->format('H:i') : '-' }}</td>
        <td class="td">{{ $row->durasi_kerja ?? '-' }}</td>
        <td class="td-c">{{ $row->jarak_meter ? number_format($row->jarak_meter, 0) : '-' }}</td>
        <td class="td-c">{{ $row->mode_kerja ?? 'WFO' }}</td>
        <td class="b-{{ $st }}">{{ $row->status ?? '-' }}</td>
    </tr>
    @empty
    <tr>
        <td class="td" colspan="11" style="text-align:center; color:#94a3b8; padding:24px;">
            Tidak ada data absensi pada periode ini
        </td>
    </tr>
    @endforelse

    {{-- Footer --}}
    <tr><td colspan="11" style="padding:3px;"></td></tr>
    <tr>
        <td class="footer" colspan="11">
            Dokumen ini digenerate otomatis oleh sistem Presenly pada {{ now()->translatedFormat('d F Y') }} pukul {{ now()->format('H:i') }} WIB.
        </td>
    </tr>
</table>
</body>
</html>
