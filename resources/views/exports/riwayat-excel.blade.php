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

        .stat-box   { font-weight: bold; font-size: 10pt; padding: 7px 14px; white-space: nowrap; border: 1px solid #e2e8f0; }
        .stat-num   { font-size: 13pt; font-weight: bold; padding: 7px 14px; text-align: center; border: 1px solid #e2e8f0; }
        .s-hadir     { background: #dcfce7; color: #15803d; }
        .s-terlambat { background: #fef9c3; color: #92400e; }
        .s-alfa      { background: #fee2e2; color: #b91c1c; }
        .s-izin      { background: #dbeafe; color: #1d4ed8; }
        .s-total     { background: #f1f5f9; color: #1e293b; }

        .th { background: #1e293b; color: #ffffff; font-weight: bold; font-size: 10pt;
              padding: 8px 10px; border: 1px solid #334155; text-align: center;
              white-space: nowrap; mso-number-format: "\@"; }
        .td      { padding: 6px 10px; border: 1px solid #e2e8f0; font-size: 10pt; mso-number-format: "\@"; }
        .td-c    { padding: 6px 10px; border: 1px solid #e2e8f0; font-size: 10pt; text-align: center; mso-number-format: "\@"; }
        .row-alt { background: #f8fafc; }
        .masuk   { color: #16a34a; font-weight: bold; }

        .b-hadir     { background: #dcfce7; color: #15803d; font-weight: bold; text-align: center;
                       border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }
        .b-terlambat { background: #fef9c3; color: #92400e; font-weight: bold; text-align: center;
                       border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }
        .b-alfa      { background: #fee2e2; color: #b91c1c; font-weight: bold; text-align: center;
                       border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }
        .b-izin      { background: #dbeafe; color: #1d4ed8; font-weight: bold; text-align: center;
                       border: 1px solid #e2e8f0; padding: 6px 10px; mso-number-format: "\@"; }

        .footer { font-size: 9pt; color: #94a3b8; padding-top: 10px; }
    </style>
</head>
<body>
<table>
    <colgroup>
        <col style="width: 40px;">
        <col style="width: 110px;">
        <col style="width: 95px;">
        <col style="width: 95px;">
        <col style="width: 95px;">
        <col style="width: 130px;">
        <col style="width: 75px;">
        <col style="width: 65px;">
        <col style="width: 105px;">
    </colgroup>

    {{-- Title --}}
    <tr><td class="title" colspan="9">Rekap Absensi Karyawan</td></tr>
    <tr><td class="subtitle" colspan="9">Presenly &ndash; Sistem Absensi Karyawan</td></tr>
    <tr><td colspan="9" style="padding:3px;"></td></tr>

    {{-- Info --}}
    <tr>
        <td class="info-label" colspan="2">Nama Karyawan</td>
        <td class="info-value" colspan="3">{{ $user->name }}</td>
        <td class="info-label">Periode</td>
        <td class="info-value" colspan="3">{{ $namaBulan }} {{ $tahun }}</td>
    </tr>
    <tr>
        <td class="info-label" colspan="2">Email</td>
        <td class="info-value" colspan="3">{{ $user->email }}</td>
        <td class="info-label">Dicetak</td>
        <td class="info-value" colspan="3">{{ now()->translatedFormat('d F Y, H:i') }}</td>
    </tr>
    <tr><td colspan="9" style="padding:3px;"></td></tr>

    {{-- Stats --}}
    <tr>
        <td class="stat-box s-hadir" colspan="2">Hadir</td>
        <td class="stat-num s-hadir">{{ $totalHadir }}</td>
        <td style="border:none;"></td>
        <td class="stat-box s-terlambat" colspan="2">Terlambat</td>
        <td class="stat-num s-terlambat">{{ $totalTerlambat }}</td>
        <td colspan="2" style="border:none;"></td>
    </tr>
    <tr>
        <td class="stat-box s-alfa" colspan="2">Alfa</td>
        <td class="stat-num s-alfa">{{ $totalAlfa }}</td>
        <td style="border:none;"></td>
        <td class="stat-box s-izin" colspan="2">Izin</td>
        <td class="stat-num s-izin">{{ $totalIzin }}</td>
        <td colspan="2" style="border:none;"></td>
    </tr>
    <tr>
        <td class="stat-box s-total" colspan="2">Total Hari Absen</td>
        <td class="stat-num s-total">{{ $riwayat->count() }}</td>
        <td colspan="6" style="border:none;"></td>
    </tr>
    <tr><td colspan="9" style="padding:3px;"></td></tr>

    {{-- Table Header --}}
    <tr>
        <th class="th">No</th>
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
    @forelse($riwayat as $i => $item)
    @php $st = strtolower($item->status ?? 'alfa'); @endphp
    <tr class="{{ $i % 2 === 1 ? 'row-alt' : '' }}">
        <td class="td-c">{{ $i + 1 }}</td>
        <td class="td">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
        <td class="td">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</td>
        <td class="td masuk">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
        <td class="td">{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
        <td class="td">{{ $item->durasi_kerja ?? '-' }}</td>
        <td class="td-c">{{ $item->jarak_meter ? number_format($item->jarak_meter, 0) : '-' }}</td>
        <td class="td-c">{{ $item->mode_kerja ?? 'WFO' }}</td>
        <td class="b-{{ $st }}">{{ $item->status ?? '-' }}</td>
    </tr>
    @empty
    <tr>
        <td class="td" colspan="9" style="text-align:center; color:#94a3b8; padding:24px;">
            Tidak ada data absensi pada periode ini
        </td>
    </tr>
    @endforelse

    {{-- Footer --}}
    <tr><td colspan="9" style="padding:3px;"></td></tr>
    <tr>
        <td class="footer" colspan="9">
            Dokumen ini digenerate otomatis oleh sistem Presenly pada {{ now()->translatedFormat('d F Y') }} pukul {{ now()->format('H:i') }} WIB.
        </td>
    </tr>
</table>
</body>
</html>
