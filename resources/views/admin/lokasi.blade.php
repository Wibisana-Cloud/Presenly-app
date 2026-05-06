@extends('layouts.admin')

@section('title', 'Lokasi Kerja')

@section('styles')
    /* LOKASI CARD */
    .lokasi-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 16px; animation: fadeUp 0.4s ease both; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .lokasi-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .lokasi-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
    .lokasi-id { font-size: 11px; color: var(--muted); background: #f8fafc; border: 1px solid var(--border); padding: 3px 8px; border-radius: 6px; font-weight: 600; }

    /* FORM */
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .btn-save { padding: 11px 24px; background: var(--green); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; margin-top: 8px; display: inline-flex; align-items: center; gap: 8px; }
    .btn-save:hover { background: var(--green-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,197,94,0.3); }

    /* COORD DISPLAY */
    .coord-display { display: flex; gap: 8px; margin-bottom: 20px; }
    .coord-chip { flex: 1; background: var(--green-light); border: 1px solid var(--green-mid); border-radius: 10px; padding: 10px 14px; }
    .coord-label { font-size: 10px; color: var(--green-dark); margin-bottom: 3px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
    .coord-val { font-size: 13px; font-weight: 700; color: var(--green-dark); font-variant-numeric: tabular-nums; }

    .empty-state { text-align: center; padding: 48px; color: var(--muted); background: var(--card); border: 1px solid var(--border); border-radius: 16px; font-size: 13px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
@endsection

@section('content')
    <h1 class="page-title">Lokasi Kerja</h1>
    <p class="page-sub">Edit koordinat GPS dan radius absensi kantor</p>

    @forelse($lokasi as $loc)
    <div class="lokasi-card">
        <div class="lokasi-header">
            <span class="lokasi-name"><i data-lucide="map-pin"></i> {{ $loc->nama_lokasi }}</span>
            <span class="lokasi-id">ID #{{ $loc->id }}</span>
        </div>

        <div class="coord-display">
            <div class="coord-chip">
                <div class="coord-label">Latitude</div>
                <div class="coord-val">{{ $loc->latitude }}</div>
            </div>
            <div class="coord-chip">
                <div class="coord-label">Longitude</div>
                <div class="coord-val">{{ $loc->longitude }}</div>
            </div>
            <div class="coord-chip">
                <div class="coord-label">Radius</div>
                <div class="coord-val">{{ $loc->radius_meter }} m</div>
            </div>
            <div class="coord-chip">
                <div class="coord-label">Jam Masuk</div>
                <div class="coord-val">{{ $loc->jam_masuk ? \Carbon\Carbon::parse($loc->jam_masuk)->format('H:i') : '-' }}</div>
            </div>
            <div class="coord-chip">
                <div class="coord-label">Jam Pulang</div>
                <div class="coord-val">{{ $loc->jam_pulang ? \Carbon\Carbon::parse($loc->jam_pulang)->format('H:i') : '-' }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.lokasi.update', $loc->id) }}">
            @csrf @method('PUT')
            <div class="field">
                <label>Nama Lokasi</label>
                <input type="text" name="nama_lokasi" value="{{ $loc->nama_lokasi }}" required>
            </div>
            <div class="field-row">
                <div class="field">
                    <label>Latitude</label>
                    <input type="text" name="latitude" value="{{ $loc->latitude }}" required placeholder="-0.586230">
                </div>
                <div class="field">
                    <label>Longitude</label>
                    <input type="text" name="longitude" value="{{ $loc->longitude }}" required placeholder="117.046151">
                </div>
            </div>
            <div class="field-row">
                <div class="field">
                    <label>Radius Absensi (meter)</label>
                    <input type="number" name="radius_meter" value="{{ $loc->radius_meter }}" required min="10">
                </div>
                <div class="field">
                    <label>Jam Masuk Standar</label>
                    <input type="time" name="jam_masuk" value="{{ $loc->jam_masuk }}">
                </div>
            </div>
            <div class="field-row">
                <div class="field">
                    <label>Jam Pulang Standar</label>
                    <input type="time" name="jam_pulang" value="{{ $loc->jam_pulang }}">
                </div>
            </div>
            <button type="submit" class="btn-save"><i data-lucide="save"></i> Simpan Perubahan</button>
        </form>
    </div>
    @empty
    <div class="empty-state">Belum ada data lokasi kerja.</div>
    @endforelse
@endsection
