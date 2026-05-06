@extends('layouts.admin')

@section('title', 'Audit Log')

@section('styles')
    /* FILTER */
    .filter-bar { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
    .filter-input { padding: 8px 12px; background: var(--white); border: 1.5px solid var(--border); border-radius: 8px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
    .filter-input:focus { border-color: var(--green); background: #f0fdf4; }
    .filter-btn { padding: 8px 18px; background: var(--green); color: white; border: none; border-radius: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
    .filter-btn:hover { background: var(--green-dark); }

    /* TABLE EXTRAS */
    .table-count { font-size: 11px; color: var(--gray); background: var(--gray-light); border: 1px solid var(--border); border-radius: 20px; padding: 2px 10px; font-weight: 600; }
    tbody td { vertical-align: top; }

    /* AKSI BADGE */
    .aksi-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; white-space: nowrap; }
    .aksi-tambah  { background: var(--green-light); color: var(--green-dark); }
    .aksi-edit    { background: #fef3c7; color: #92400e; }
    .aksi-hapus   { background: #fef2f2; color: var(--red); }
    .aksi-setujui { background: var(--green-light); color: var(--green-dark); }
    .aksi-tolak   { background: #fef2f2; color: var(--red); }
    .aksi-lokasi  { background: #ede9fe; color: #7c3aed; }
    .aksi-default { background: var(--gray-light); color: var(--gray); }

    /* PAGINATION */
    .pagination-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); }
    .pagination-info { font-size: 12px; color: var(--gray); }
    .pagination-btns { display: flex; align-items: center; gap: 6px; }
    .page-btn { display: inline-flex; align-items: center; gap: 4px; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: 1.5px solid var(--border); background: var(--white); color: var(--text); }
    .page-btn:hover { border-color: var(--green-mid); color: var(--green-dark); background: var(--green-light); }
    .page-btn.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
    .page-current { padding: 7px 12px; font-size: 12px; font-weight: 700; color: var(--green-dark); background: var(--green-light); border: 1.5px solid var(--green-mid); border-radius: 8px; }

    .empty-cell { text-align: center; padding: 48px; color: var(--gray); font-size: 13px; }
@endsection

@section('content')
    <h1 class="page-title">Audit Log</h1>
    <p class="page-sub">Rekam jejak semua aktivitas admin dalam sistem</p>

    <form method="GET" action="{{ route('admin.audit_log') }}" class="filter-bar">
        <input type="text" name="search" class="filter-input" placeholder="Cari nama admin..."
               value="{{ $search }}" style="min-width: 200px;">
        <select name="aksi" class="filter-input">
            <option value="">Semua Aksi</option>
            @foreach($aksiList as $item)
                <option value="{{ $item }}" {{ $aksi === $item ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        <button type="submit" class="filter-btn">Filter</button>
        @if($search || $aksi)
            <a href="{{ route('admin.audit_log') }}" class="filter-btn" style="background:var(--gray-light);color:var(--gray);border:1.5px solid var(--border);text-decoration:none;">Reset</a>
        @endif
    </form>

    <div class="table-card">
        <div class="table-header">
            <span class="table-title"><i data-lucide="shield-check"></i> Log Aktivitas</span>
            <span class="table-count">{{ $logs->total() }} entri</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="white-space: nowrap;">
                        <div style="font-weight: 600; color: var(--dark);">{{ $log->created_at->format('d/m/Y') }}</div>
                        <div class="td-muted">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $log->user->name ?? '—' }}</div>
                        <div class="td-muted">{{ $log->user->email ?? '' }}</div>
                    </td>
                    <td>
                        @php
                            $aksiClass = match(true) {
                                str_starts_with($log->aksi, 'Tambah') => 'aksi-tambah',
                                str_starts_with($log->aksi, 'Edit')   => 'aksi-edit',
                                str_starts_with($log->aksi, 'Hapus')  => 'aksi-hapus',
                                str_starts_with($log->aksi, 'Setujui') => 'aksi-setujui',
                                str_starts_with($log->aksi, 'Tolak')  => 'aksi-tolak',
                                str_starts_with($log->aksi, 'Update') => 'aksi-lokasi',
                                default => 'aksi-default',
                            };
                        @endphp
                        <span class="aksi-badge {{ $aksiClass }}">{{ $log->aksi }}</span>
                    </td>
                    <td style="color: var(--gray); max-width: 360px; line-height: 1.5;">
                        {{ $log->deskripsi }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-cell">
                        <i data-lucide="inbox" style="width:24px;height:24px;display:block;margin:0 auto 8px;opacity:0.4;"></i>
                        Belum ada aktivitas yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
        <div class="pagination-wrap">
            <span class="pagination-info">
                Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} entri
            </span>
            <div class="pagination-btns">
                @if($logs->onFirstPage())
                    <span class="page-btn disabled"><i data-lucide="chevron-left"></i> Sebelumnya</span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="page-btn"><i data-lucide="chevron-left"></i> Sebelumnya</a>
                @endif
                <span class="page-current">{{ $logs->currentPage() }} / {{ $logs->lastPage() }}</span>
                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="page-btn">Selanjutnya <i data-lucide="chevron-right"></i></a>
                @else
                    <span class="page-btn disabled">Selanjutnya <i data-lucide="chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection
