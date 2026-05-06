@extends('layouts.admin')

@section('title', 'Hari Libur')

@section('styles')
    /* CARDS */
    .grid-2 { display: grid; grid-template-columns: 1fr 1.6fr; gap: 20px; margin-bottom: 24px; }
    .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

    /* FORM */
    .form-group { margin-bottom: 14px; }
    label { display: block; font-size: 12px; color: var(--muted); margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
    input[type="date"], input[type="text"], select {
        width: 100%; background: #f8fafc; border: 1.5px solid var(--border);
        border-radius: 8px; padding: 10px 12px; color: var(--text);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s;
    }
    input:focus, select:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
    input::placeholder { color: #94a3b8; }

    .btn { padding: 10px 20px; border-radius: 8px; border: none; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    .btn-green { background: var(--green); color: white; width: 100%; margin-top: 4px; }
    .btn-green:hover { background: var(--green-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,197,94,0.3); }
    .btn-sync { background: #eff6ff; color: var(--blue); border: 1.5px solid #bfdbfe; padding: 10px 20px; }
    .btn-sync:hover { background: #dbeafe; }
    .btn-red { background: #fef2f2; color: var(--red); border: 1px solid #fecaca; padding: 6px 12px; font-size: 12px; font-weight: 600; }
    .btn-red:hover { background: #fee2e2; }

    /* FILTER ROW */
    .filter-row { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
    .filter-row select { width: auto; }
    .filter-row .total { font-size: 12px; color: var(--muted); margin-left: auto; }

    /* SYNC ROW */
    .sync-row { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 14px 16px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; }
    .sync-info { flex: 1; font-size: 12px; color: var(--muted); }
    .sync-info strong { color: var(--blue); display: block; font-size: 13px; margin-bottom: 2px; font-weight: 700; }

    /* DIVIDER */
    .card-divider { margin: 24px 0 20px; padding-top: 20px; border-top: 1px solid var(--border); }

    /* TABLE */
    .table-wrap { overflow-x: auto; }
    .td-name { font-weight: 600; color: var(--dark); }

    /* BADGES */
    .badge.nasional { background: var(--green-light); color: var(--green-dark); border: 1px solid var(--green-mid); }
    .badge.manual   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

    /* STATS */
    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
    .stat-card { background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 14px 16px; text-align: center; }
    .stat-num { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; }
    .stat-num.green  { color: var(--green-dark); }
    .stat-num.yellow { color: var(--yellow); }
    .stat-num.blue   { color: var(--blue); }
    .stat-label { font-size: 11px; color: var(--muted); margin-top: 2px; }

    .empty { text-align: center; padding: 40px; color: var(--muted); font-size: 13px; }
@endsection

@section('content')
    <div class="page-header" style="margin-bottom:28px;">
        <h1 class="page-title" style="display:flex;align-items:center;gap:10px;"><i data-lucide="calendar-off"></i> Hari Libur</h1>
        <p class="page-sub">Kelola hari libur nasional dan khusus perusahaan</p>
    </div>

    <div class="grid-2">
        <!-- Form tambah manual -->
        <div class="card">
            <div class="card-title"><i data-lucide="plus-circle"></i> Tambah Hari Libur Manual</div>

            <form method="POST" action="{{ route('admin.hari_libur.store') }}">
                @csrf
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal') <div style="color:var(--red);font-size:11px;margin-top:4px">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Nama Hari Libur</label>
                    <input type="text" name="nama" placeholder="cth: Hari Jadi Kota" value="{{ old('nama') }}" required>
                    @error('nama') <div style="color:var(--red);font-size:11px;margin-top:4px">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-green">Tambahkan</button>
            </form>

            <div class="card-divider">
                <div class="card-title"><i data-lucide="refresh-cw"></i> Sinkronisasi API</div>
                <div class="sync-row" style="flex-direction:column;align-items:flex-start">
                    <div class="sync-info">
                        <strong>Hari Libur Nasional Indonesia</strong>
                        Ambil otomatis dari API harilibur.vercel.app
                    </div>
                    <form method="POST" action="{{ route('admin.hari_libur.sync') }}" style="display:flex;gap:10px;margin-top:10px;width:100%">
                        @csrf
                        <select name="tahun" style="flex:1">
                            @foreach($tahunList as $t)
                                <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sync">Sinkronisasi</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar hari libur -->
        <div class="card">
            <div class="filter-row">
                <div class="card-title" style="margin:0"><i data-lucide="calendar"></i> Daftar Hari Libur</div>
                <form method="GET" style="display:flex;gap:8px;margin-left:auto">
                    <select name="tahun" onchange="this.form.submit()">
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-num green">{{ $hariLibur->count() }}</div>
                    <div class="stat-label">Total</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num blue">{{ $hariLibur->where('tipe','nasional')->count() }}</div>
                    <div class="stat-label">Nasional</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num yellow">{{ $hariLibur->where('tipe','manual')->count() }}</div>
                    <div class="stat-label">Manual</div>
                </div>
            </div>

            @if($hariLibur->isEmpty())
                <div class="empty">
                    Belum ada data hari libur untuk tahun {{ $tahun }}.<br>
                    Klik <strong>Sinkronisasi</strong> untuk import otomatis!
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hariLibur as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                <td class="td-name">{{ $item->nama }}</td>
                                <td>
                                    <span class="badge {{ $item->tipe }}">
                                        @if($item->tipe === 'nasional')
                                            <i data-lucide="flag"></i> Nasional
                                        @else
                                            <i data-lucide="pencil"></i> Manual
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($item->is_manual)
                                    <form method="POST" action="{{ route('admin.hari_libur.destroy', $item->id) }}"
                                        onsubmit="return confirm('Hapus hari libur ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red">Hapus</button>
                                    </form>
                                    @else
                                    <span style="font-size:11px;color:var(--muted)">–</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
