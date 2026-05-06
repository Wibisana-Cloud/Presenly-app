@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('styles')
    .card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 22px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .field { margin-bottom: 14px; }
    .field textarea { resize: vertical; min-height: 100px; width: 100%; }
    .field input { width: 100%; }
    .btn-add { padding: 10px 22px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .pengumuman-list { display: flex; flex-direction: column; gap: 12px; }
    .pengumuman-item { background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; display: flex; align-items: flex-start; gap: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .pengumuman-item.inactive { opacity: 0.55; }
    .pengumuman-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--green-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .pengumuman-icon [data-lucide] { width: 18px; height: 18px; color: var(--green-dark); }
    .pengumuman-body { flex: 1; min-width: 0; }
    .pengumuman-judul { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 4px; }
    .pengumuman-isi { font-size: 13px; color: var(--muted); line-height: 1.5; white-space: pre-wrap; }
    .pengumuman-meta { font-size: 11px; color: #94a3b8; margin-top: 8px; }
    .badge-aktif { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; }
    .badge-aktif.on  { background: var(--green-light); color: var(--green-dark); }
    .badge-aktif.off { background: #f1f5f9; color: var(--muted); }
    .action-btns { display: flex; gap: 6px; flex-shrink: 0; }
    .btn-edit { padding: 5px 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; color: var(--blue); font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; }
    .btn-toggle { padding: 5px 12px; background: var(--green-light); border: 1px solid var(--green-mid); border-radius: 6px; color: var(--green-dark); font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; }
    .btn-delete { padding: 5px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; color: var(--red); font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; }
    .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
    .btn-save { flex: 1; padding: 11px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-cancel-modal { padding: 11px 20px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; cursor: pointer; font-weight: 500; }
@endsection

@section('content')
    <h1 class="page-title">Pengumuman</h1>
    <p class="page-sub">Buat dan kelola pengumuman untuk karyawan</p>

    <!-- Form Tambah -->
    <div class="card">
        <div class="section-title"><i data-lucide="plus-circle"></i> Buat Pengumuman Baru</div>
        <form method="POST" action="{{ route('admin.pengumuman.store') }}">
            @csrf
            <div class="field">
                <label>Judul Pengumuman</label>
                <input type="text" name="judul" placeholder="Contoh: Libur Nasional 17 Agustus" required value="{{ old('judul') }}">
            </div>
            <div class="field">
                <label>Isi Pengumuman</label>
                <textarea name="isi" placeholder="Tulis isi pengumuman di sini..." required>{{ old('isi') }}</textarea>
            </div>
            @if($errors->any())
                <p style="color: var(--red); font-size: 12px; margin-bottom: 12px;">{{ $errors->first() }}</p>
            @endif
            <button type="submit" class="btn-add">Publikasikan</button>
        </form>
    </div>

    <!-- Daftar Pengumuman -->
    <div class="section-title" style="margin-bottom:12px;"><i data-lucide="list"></i> Daftar Pengumuman ({{ $pengumumans->count() }})</div>
    @if($pengumumans->isEmpty())
        <div class="card" style="text-align:center;color:var(--muted);padding:40px;">
            <i data-lucide="megaphone" style="width:32px;height:32px;display:block;margin:0 auto 8px;opacity:0.3;"></i>
            Belum ada pengumuman.
        </div>
    @else
        <div class="pengumuman-list">
            @foreach($pengumumans as $p)
            <div class="pengumuman-item {{ $p->is_aktif ? '' : 'inactive' }}">
                <div class="pengumuman-icon"><i data-lucide="megaphone"></i></div>
                <div class="pengumuman-body">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                        <span class="pengumuman-judul">{{ $p->judul }}</span>
                        <span class="badge-aktif {{ $p->is_aktif ? 'on' : 'off' }}">
                            {{ $p->is_aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <div class="pengumuman-isi">{{ $p->isi }}</div>
                    <div class="pengumuman-meta">
                        Oleh {{ $p->dibuatOleh->name ?? 'Admin' }} &bull;
                        {{ $p->created_at->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>
                <div class="action-btns">
                    <button type="button" class="btn-edit" onclick="openEditModal({{ $p->id }}, '{{ addslashes($p->judul) }}', {{ json_encode($p->isi) }})">
                        Edit
                    </button>
                    <form method="POST" action="{{ route('admin.pengumuman.toggle', $p->id) }}" style="margin:0">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-toggle">
                            {{ $p->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.pengumuman.destroy', $p->id) }}"
                          onsubmit="return confirm('Hapus pengumuman ini?')" style="margin:0">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Modal Edit -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-title">Edit Pengumuman</div>
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="field">
                    <label>Judul</label>
                    <input type="text" name="judul" id="editJudul" required>
                </div>
                <div class="field">
                    <label>Isi</label>
                    <textarea name="isi" id="editIsi" required></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel-modal" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function openEditModal(id, judul, isi) {
    document.getElementById('editForm').action = '/admin/pengumuman/' + id;
    document.getElementById('editJudul').value = judul;
    document.getElementById('editIsi').value   = isi;
    document.getElementById('editModal').classList.add('open');
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('open');
}
document.getElementById('editModal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });
</script>
@endpush
