@extends('layouts.admin')

@section('title', 'Departemen')

@section('styles')
    .card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 22px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr 2fr auto; gap: 12px; align-items: end; }
    .btn-add { padding: 10px 22px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; white-space: nowrap; }
    .badge-count { display: inline-block; background: var(--green-light); color: var(--green-dark); font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px; }
    .action-btns { display: flex; gap: 6px; }
    .btn-edit { padding: 5px 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; color: var(--blue); font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; }
    .btn-delete { padding: 5px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; color: var(--red); font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; }
    .empty-row td { text-align: center; padding: 40px; color: var(--muted); }
    .modal-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
    .modal-field label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
    .modal-field input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; width: 100%; }
    .modal-field input:focus { border-color: var(--green); background: #f0fdf4; }
    .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
    .btn-save { flex: 1; padding: 11px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-cancel-modal { padding: 11px 20px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; cursor: pointer; font-weight: 500; }
@endsection

@section('content')
    <h1 class="page-title">Departemen</h1>
    <p class="page-sub">Kelola departemen / divisi karyawan</p>

    <!-- Form Tambah -->
    <div class="card">
        <div class="section-title"><i data-lucide="plus-circle"></i> Tambah Departemen</div>
        <form method="POST" action="{{ route('admin.departemen.store') }}">
            @csrf
            <div class="form-row">
                <div class="field">
                    <label>Nama Departemen</label>
                    <input type="text" name="nama" placeholder="Contoh: IT, HR, Finance" required value="{{ old('nama') }}">
                </div>
                <div class="field">
                    <label>Kode (opsional)</label>
                    <input type="text" name="kode" placeholder="Contoh: IT-01" value="{{ old('kode') }}">
                </div>
                <div class="field">
                    <label>Deskripsi (opsional)</label>
                    <input type="text" name="deskripsi" placeholder="Keterangan singkat" value="{{ old('deskripsi') }}">
                </div>
                <button type="submit" class="btn-add">Tambah</button>
            </div>
            @if($errors->any())
                <p style="color: var(--red); font-size: 12px; margin-top: 10px;">{{ $errors->first() }}</p>
            @endif
        </form>
    </div>

    <!-- Tabel Departemen -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Kode</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Karyawan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departemens as $i => $dep)
                <tr>
                    <td style="color:var(--muted)">{{ $i + 1 }}</td>
                    <td style="font-weight:600">{{ $dep->nama }}</td>
                    <td style="color:var(--muted)">{{ $dep->kode ?? '-' }}</td>
                    <td style="color:var(--muted)">{{ $dep->deskripsi ?? '-' }}</td>
                    <td><span class="badge-count">{{ $dep->karyawan_count }} karyawan</span></td>
                    <td>
                        <div class="action-btns">
                            <button type="button" class="btn-edit"
                                onclick="openEditModal({{ $dep->id }}, '{{ addslashes($dep->nama) }}', '{{ addslashes($dep->kode ?? '') }}', '{{ addslashes($dep->deskripsi ?? '') }}')">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.departemen.destroy', $dep->id) }}"
                                  onsubmit="return confirm('Hapus departemen {{ $dep->nama }}? Karyawan di dalamnya tidak akan terhapus.')" style="margin:0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="6">Belum ada departemen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Edit -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-title">Edit Departemen</div>
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="modal-field">
                    <label>Nama Departemen</label>
                    <input type="text" name="nama" id="editNama" required>
                </div>
                <div class="modal-field">
                    <label>Kode (opsional)</label>
                    <input type="text" name="kode" id="editKode">
                </div>
                <div class="modal-field">
                    <label>Deskripsi (opsional)</label>
                    <input type="text" name="deskripsi" id="editDeskripsi">
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
function openEditModal(id, nama, kode, deskripsi) {
    document.getElementById('editForm').action = '/admin/departemen/' + id;
    document.getElementById('editNama').value     = nama;
    document.getElementById('editKode').value     = kode;
    document.getElementById('editDeskripsi').value = deskripsi;
    document.getElementById('editModal').classList.add('open');
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('open');
}
document.getElementById('editModal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });
</script>
@endpush
