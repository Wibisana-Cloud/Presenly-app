@extends('layouts.admin')

@section('title', 'Jadwal Mode Kerja')

@section('styles')
    /* LAYOUT */
    .layout { display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start; }

    /* FORM CARD */
    .form-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s ease both; }
    .card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
    .card-header-title { font-size: 13px; font-weight: 700; color: var(--dark); }
    .card-body { padding: 20px; }

    /* INFO BOX */
    .info-box { display: flex; align-items: flex-start; gap: 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 12px 14px; margin-bottom: 18px; }
    .info-box [data-lucide] { width: 14px; height: 14px; flex-shrink: 0; color: var(--blue); margin-top: 2px; }
    .info-box-text { flex: 1; font-size: 12px; color: #1d4ed8; line-height: 1.6; }

    /* FIELDS */
    .field-hint { font-size: 11px; color: var(--muted); font-weight: 400; margin-left: 4px; }
    .field-error { font-size: 11px; color: var(--red); margin-top: 4px; display: block; }

    /* MODE SELECTOR */
    .mode-options { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .mode-option { position: relative; }
    .mode-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .mode-option label { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 16px 10px; border: 2px solid var(--border); border-radius: 12px; cursor: pointer; transition: all 0.2s; background: #f8fafc; }
    .mode-option label [data-lucide] { width: 22px; height: 22px; color: var(--muted); transition: color 0.2s; }
    .mode-option input[type="radio"]:checked + label.wfo { border-color: var(--green); background: var(--green-light); }
    .mode-option input[type="radio"]:checked + label.wfo [data-lucide] { color: var(--green-dark); }
    .mode-option input[type="radio"]:checked + label.wfa { border-color: var(--blue); background: #eff6ff; }
    .mode-option input[type="radio"]:checked + label.wfa [data-lucide] { color: #1d4ed8; }
    .mode-name { font-size: 13px; font-weight: 700; color: var(--dark); }
    .mode-option input[type="radio"]:checked + label.wfo .mode-name { color: var(--green-dark); }
    .mode-option input[type="radio"]:checked + label.wfa .mode-name { color: #1d4ed8; }
    .mode-desc { font-size: 10px; color: var(--muted); text-align: center; line-height: 1.4; }

    .btn-save { width: 100%; padding: 11px; background: var(--green); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 4px; }
    .btn-save:hover { background: var(--green-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,197,94,0.25); }

    /* TABLE CARD */
    .count-chip { font-size: 12px; color: var(--muted); background: #f8fafc; border: 1px solid var(--border); border-radius: 20px; padding: 2px 10px; font-weight: 600; }

    .td-date { font-weight: 600; color: var(--dark); white-space: nowrap; }
    .td-sub { font-size: 11px; color: var(--muted); margin-top: 2px; }

    .mode-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; white-space: nowrap; }
    .mode-badge.WFO { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
    .mode-badge.WFA { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }
    .mode-badge [data-lucide] { width: 11px; height: 11px; }

    .today-badge { font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 4px; background: #fef3c7; border: 1px solid #fde68a; color: #92400e; margin-left: 6px; vertical-align: middle; }

    .btn-delete { padding: 6px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 7px; color: var(--red); font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; }
    .btn-delete:hover { background: #fee2e2; }
    .btn-delete [data-lucide] { width: 12px; height: 12px; }

    .empty-state { padding: 56px 24px; text-align: center; color: var(--muted); }
    .empty-state-icon { width: 48px; height: 48px; background: #f1f5f9; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .empty-state-icon [data-lucide] { width: 24px; height: 24px; color: #94a3b8; }
    .empty-state p { font-size: 13px; line-height: 1.6; }
@endsection

@section('content')
    <div class="page-header" style="margin-bottom:24px;animation:fadeUp 0.4s ease both;">
        <h1 class="page-title">Jadwal Mode Kerja</h1>
        <p class="page-sub">Tentukan tanggal WFO atau WFA untuk seluruh karyawan</p>
    </div>

    <div class="layout">

        {{-- Form Tambah --}}
        <div class="form-card">
            <div class="card-header">
                <i data-lucide="plus-circle" style="width:15px;height:15px;color:var(--green-dark);"></i>
                <span class="card-header-title">Tambah Jadwal</span>
            </div>
            <div class="card-body">
                <div class="info-box">
                    <i data-lucide="info"></i>
                    <span class="info-box-text">
                        Default semua hari adalah <strong>WFO</strong>. Tambahkan jadwal hanya untuk hari yang berbeda dari default.
                    </span>
                </div>

                <form method="POST" action="{{ route('admin.jadwal_mode.store') }}">
                    @csrf

                    <div class="field">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                               min="{{ today()->toDateString() }}" required>
                        @error('tanggal') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label>Mode Kerja</label>
                        <div class="mode-options">
                            <div class="mode-option">
                                <input type="radio" name="mode" id="mode_wfo" value="WFO"
                                       {{ old('mode', 'WFO') === 'WFO' ? 'checked' : '' }}>
                                <label for="mode_wfo" class="wfo">
                                    <i data-lucide="building-2"></i>
                                    <span class="mode-name">WFO</span>
                                    <span class="mode-desc">Di kantor</span>
                                </label>
                            </div>
                            <div class="mode-option">
                                <input type="radio" name="mode" id="mode_wfa" value="WFA"
                                       {{ old('mode') === 'WFA' ? 'checked' : '' }}>
                                <label for="mode_wfa" class="wfa">
                                    <i data-lucide="laptop"></i>
                                    <span class="mode-name">WFA</span>
                                    <span class="mode-desc">Remote / dari mana saja</span>
                                </label>
                            </div>
                        </div>
                        @error('mode') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label>Keterangan <span class="field-hint">(opsional)</span></label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                               placeholder="mis. WFA karena renovasi kantor">
                    </div>

                    <button type="submit" class="btn-save">
                        <i data-lucide="save" style="width:15px;height:15px;"></i> Simpan Jadwal
                    </button>
                </form>
            </div>
        </div>

        {{-- Daftar Jadwal --}}
        <div class="table-card">
            <div class="card-header">
                <i data-lucide="calendar-check" style="width:15px;height:15px;color:var(--green-dark);"></i>
                <span class="card-header-title">Daftar Jadwal</span>
                <span class="count-chip" style="margin-left:auto;">{{ $jadwals->count() }} jadwal</span>
            </div>

            @if($jadwals->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon"><i data-lucide="calendar-x"></i></div>
                    <p>Belum ada jadwal ditambahkan.<br>Semua hari berjalan dengan mode <strong>WFO</strong> (default).</p>
                </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mode</th>
                        <th>Keterangan</th>
                        <th>Dibuat Oleh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $jadwal)
                    <tr>
                        <td>
                            <div class="td-date">
                                {{ $jadwal->tanggal->translatedFormat('l, d M Y') }}
                                @if($jadwal->tanggal->isToday())
                                    <span class="today-badge">Hari Ini</span>
                                @endif
                            </div>
                            <div class="td-sub">{{ $jadwal->tanggal->translatedFormat('Y') }}</div>
                        </td>
                        <td>
                            <span class="mode-badge {{ $jadwal->mode }}">
                                @if($jadwal->mode === 'WFO')
                                    <i data-lucide="building-2"></i> WFO
                                @else
                                    <i data-lucide="laptop"></i> WFA
                                @endif
                            </span>
                        </td>
                        <td>
                            <span style="font-size:12px;color:var(--muted);">{{ $jadwal->keterangan ?? '—' }}</span>
                        </td>
                        <td>
                            <span style="font-size:12px;color:var(--muted);">{{ $jadwal->dibuatOleh->name ?? '—' }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.jadwal_mode.destroy', $jadwal->id) }}"
                                  onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i data-lucide="trash-2"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>
@endsection
