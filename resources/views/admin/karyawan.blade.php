@extends('layouts.admin')

@section('title', 'Kelola Karyawan')

@section('styles')
    /* ADD FORM */
    .add-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 22px; margin-bottom: 20px; animation: fadeUp 0.4s ease both; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: end; }
    .field input:focus { box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
    .field input::placeholder { color: #94a3b8; }
    .btn-add { padding: 10px 20px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; white-space: nowrap; box-shadow: 0 3px 10px rgba(34,197,94,0.3); }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(34,197,94,0.4); }

    /* SEARCH */
    .search-wrap { position: relative; }
    .search-wrap [data-lucide] { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: var(--muted); pointer-events: none; }
    .search-input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 8px; padding: 8px 12px 8px 34px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; width: 220px; transition: all 0.2s; }
    .search-input:focus { border-color: var(--green); background: #f0fdf4; }
    .search-input::placeholder { color: #94a3b8; }

    /* TABLE OVERRIDES */
    .table-card { animation: fadeUp 0.4s 0.1s ease both; }
    thead th { background: linear-gradient(to bottom, #f8fafc, #f1f5f9); }
    tbody td { padding: 13px 16px; }
    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-rekap { padding: 5px 12px; background: var(--green-light); border: 1px solid var(--green-mid); border-radius: 6px; color: var(--green-dark); font-size: 11px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; }
    .btn-rekap:hover { background: var(--green-mid); }
    .btn-edit { padding: 5px 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; color: var(--blue); font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
    .btn-edit:hover { background: #dbeafe; }
    .btn-delete { padding: 5px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; color: var(--red); font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
    .btn-delete:hover { background: #fee2e2; }
    .empty-row td { text-align: center; padding: 48px; color: var(--muted); font-size: 13px; }

    /* MODAL */
    .modal-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
    .modal-field label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
    .modal-field input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
    .modal-field input:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
    .modal-field input::placeholder { color: #94a3b8; }
    .modal-hint { font-size: 11px; color: var(--muted); margin-top: 3px; }
    .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
    .btn-save { flex: 1; padding: 11px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 3px 10px rgba(34,197,94,0.25); }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(34,197,94,0.4); }
    .btn-cancel-modal { padding: 11px 20px; background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; color: var(--muted); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; cursor: pointer; transition: all 0.2s; font-weight: 500; }
    .btn-cancel-modal:hover { border-color: #94a3b8; color: var(--text); }
@endsection

@section('content')
    <h1 class="page-title">Kelola Karyawan</h1>
    <p class="page-sub">Tambah, lihat, dan hapus data karyawan</p>

    <!-- Form Tambah -->
    <div class="add-card">
        <div class="section-title"><i data-lucide="user-plus"></i> Tambah Karyawan Baru</div>
        <form method="POST" action="{{ route('admin.karyawan.store') }}">
            @csrf
            <div class="form-row">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Nama karyawan" required value="{{ old('name') }}">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email@example.com" required value="{{ old('email') }}">
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 6 karakter" required>
                </div>
                <button type="submit" class="btn-add">Tambah</button>
            </div>
            @if($errors->any())
                <p style="color: var(--red); font-size: 12px; margin-top: 10px;">{{ $errors->first() }}</p>
            @endif
        </form>
    </div>

    <!-- Tabel Karyawan -->
    <div class="table-card">
        <div class="table-header">
            <span class="section-title" style="margin:0">
                Daftar Karyawan
                @if($search)
                    <span style="font-family:'DM Sans',sans-serif; font-weight:400; color:var(--muted); font-size:12px; text-transform:none; letter-spacing:0;">({{ $karyawan->count() }} dari {{ $totalKaryawan }})</span>
                @else
                    <span style="font-family:'DM Sans',sans-serif; font-weight:400; color:var(--muted); font-size:12px; text-transform:none; letter-spacing:0;">({{ $karyawan->count() }})</span>
                @endif
            </span>
            <form method="GET" action="{{ route('admin.karyawan') }}" style="margin:0">
                <div class="search-wrap">
                    <i data-lucide="search"></i>
                    <input type="text" name="search" class="search-input"
                           placeholder="Cari nama / email…"
                           value="{{ $search }}"
                           oninput="this.form.requestSubmit()">
                </div>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawan as $i => $k)
                <tr>
                    <td class="td-muted">{{ $i + 1 }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-av">{{ strtoupper(substr($k->name, 0, 1)) }}</div>
                            <span class="user-name">{{ $k->name }}</span>
                        </div>
                    </td>
                    <td class="td-muted">{{ $k->email }}</td>
                    <td class="td-muted">{{ \Carbon\Carbon::parse($k->created_at)->translatedFormat('d F Y') }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.karyawan.show', $k->id) }}" class="btn-rekap">
                                <i data-lucide="bar-chart-2"></i> Rekap
                            </a>
                            <button type="button" class="btn-edit"
                                onclick="openEditModal({{ $k->id }}, '{{ addslashes($k->name) }}', '{{ $k->email }}')">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.karyawan.destroy', $k->id) }}"
                                onsubmit="return confirm('Hapus karyawan {{ $k->name }}?')" style="margin:0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="5">Belum ada karyawan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL EDIT KARYAWAN --}}
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-title">Edit Data Karyawan</div>
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="modal-field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" id="editName" placeholder="Nama karyawan" required>
                </div>
                <div class="modal-field">
                    <label>Email</label>
                    <input type="email" name="email" id="editEmail" placeholder="email@example.com" required>
                </div>
                <div class="modal-field">
                    <label>Password Baru</label>
                    <input type="password" name="password" id="editPassword" placeholder="Kosongkan jika tidak diganti">
                    <span class="modal-hint">Isi hanya jika ingin mengganti password (min. 6 karakter)</span>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel-modal" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function openEditModal(id, name, email) {
    document.getElementById('editForm').action = '/admin/karyawan/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPassword').value = '';
    document.getElementById('editModal').classList.add('open');
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('open');
}
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endpush
