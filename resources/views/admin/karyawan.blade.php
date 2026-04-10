<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Karyawan – Presenly Admin</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-deeper: #15803d;
            --green-light: #dcfce7; --green-mid: #bbf7d0;
            --dark: #0f172a; --card: #ffffff; --border: #e2e8f0;
            --muted: #64748b; --white: #ffffff; --text: #1e293b;
            --red: #ef4444; --yellow: #f59e0b; --blue: #3b82f6;
            --sidebar-w: 230px; --bg: #eef4fb;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; min-height: 100vh; display: flex; }

                /* SIDEBAR GELAP */
        .sidebar { width: var(--sidebar-w); min-height: 100vh; background: #0f172a; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 50; box-shadow: 4px 0 24px rgba(0,0,0,0.18); }
        .sidebar-logo { display: flex; align-items: center; gap: 10px; padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .logo-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; color: white; box-shadow: 0 4px 12px rgba(34,197,94,0.35); }
        .logo-text { font-weight: 700; font-size: 17px; color: white; }
        .logo-badge { font-size: 9px; background: rgba(34,197,94,0.18); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; padding: 1px 6px; border-radius: 4px; margin-left: auto; font-weight: 700; }
        .sidebar-nav { flex: 1; padding: 0 12px; overflow-y: auto; }
        .nav-label { font-size: 10px; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 0.8px; padding: 0 8px; margin: 16px 0 6px; font-weight: 600; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; text-decoration: none; color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 500; transition: all 0.2s; margin-bottom: 2px; border: 1px solid transparent; }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.9); }
        .nav-item.active { background: linear-gradient(135deg, rgba(34,197,94,0.22), rgba(34,197,94,0.08)); color: #4ade80; font-weight: 600; border-color: rgba(34,197,94,0.2); }
        .nav-item [data-lucide] { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-badge { margin-left: auto; background: #ef4444; color: white; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 10px; line-height: 1.6; }
        .sidebar-footer { padding: 16px 12px 0; border-top: 1px solid rgba(255,255,255,0.07); margin-top: 8px; }
        .admin-chip { display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; margin-bottom: 8px; }
        .admin-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #22c55e, #16a34a); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; flex-shrink: 0; }
        .admin-info { flex: 1; min-width: 0; }
        .admin-name { font-size: 12px; font-weight: 600; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-role { font-size: 10px; color: #4ade80; font-weight: 600; }
        .logout-btn { width: 100%; padding: 9px; background: transparent; border: 1px solid rgba(239,68,68,0.35); border-radius: 8px; color: #f87171; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; cursor: pointer; font-weight: 600; transition: all 0.2s; }
        .logout-btn:hover { background: rgba(239,68,68,0.12); }



        /* MAIN */
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 28px 40px; position: relative; z-index: 1; }
        .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; color: var(--dark); }
        .page-sub { font-size: 12px; color: var(--muted); margin-bottom: 24px; }

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert.success { background: var(--green-light); border: 1px solid var(--green-mid); color: var(--green-dark); }
        .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* ADD FORM */
        .add-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 22px; margin-bottom: 20px; animation: fadeUp 0.4s ease both; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .section-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--muted); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: end; }
        .field { display: flex; flex-direction: column; gap: 6px; }
        .field label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
        .field input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; transition: all 0.2s; }
        .field input:focus { border-color: var(--green); background: #f0fdf4; box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
        .field input::placeholder { color: #94a3b8; }
        .btn-add { padding: 10px 20px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 10px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; white-space: nowrap; box-shadow: 0 3px 10px rgba(34,197,94,0.3); }
        .btn-add:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(34,197,94,0.4); }

        /* SEARCH */
        .search-wrap { position: relative; }
        .search-wrap [data-lucide] { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: var(--muted); pointer-events: none; }
        .search-input { background: #f8fafc; border: 1.5px solid var(--border); border-radius: 8px; padding: 8px 12px 8px 34px; color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; outline: none; width: 220px; transition: all 0.2s; }
        .search-input:focus { border-color: var(--green); background: #f0fdf4; }
        .search-input::placeholder { color: #94a3b8; }

        /* TABLE */
        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; animation: fadeUp 0.4s 0.1s ease both; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-header { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); background: linear-gradient(to bottom, #f8fafc, #f1f5f9); }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: linear-gradient(to right, #f0fdf4, #f8fafc); }
        tbody td { padding: 13px 16px; font-size: 13px; color: var(--text); }
        .user-cell { display: flex; align-items: center; gap: 10px; }
        .user-av { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--green-deeper)); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; flex-shrink: 0; }
        .user-name { font-weight: 600; color: var(--dark); }
        .td-muted { color: var(--muted); font-size: 13px; }
        .action-btns { display: flex; gap: 6px; align-items: center; }
        .btn-rekap { padding: 5px 12px; background: var(--green-light); border: 1px solid var(--green-mid); border-radius: 6px; color: var(--green-dark); font-size: 11px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; }
        .btn-rekap:hover { background: var(--green-mid); }
        .btn-edit { padding: 5px 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; color: var(--blue); font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
        .btn-edit:hover { background: #dbeafe; }
        .btn-delete { padding: 5px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; color: var(--red); font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
        .btn-delete:hover { background: #fee2e2; }
        .empty-row td { text-align: center; padding: 48px; color: var(--muted); font-size: 13px; }

        /* MODAL */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.35); z-index: 200; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
        .modal-overlay.open { display: flex; }
        .modal { background: var(--white); border: 1px solid var(--border); border-radius: 18px; padding: 28px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); animation: fadeUp 0.25s ease both; }
        .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; margin-bottom: 20px; color: var(--dark); }
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

        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">P</div>
        <span class="logo-text">Presenly</span>
        <span class="logo-badge">ADMIN</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i data-lucide="layout-dashboard"></i> Dashboard</a>
        <a href="{{ route('admin.karyawan') }}" class="nav-item active"><i data-lucide="users"></i> Karyawan</a>
        <a href="{{ route('admin.absensi') }}" class="nav-item"><i data-lucide="clipboard-list"></i> Semua Absensi</a>
        <a href="{{ route('admin.izin') }}" class="nav-item"><i data-lucide="file-clock"></i> Izin @if($izinPendingCount > 0)<span class="nav-badge">{{ $izinPendingCount }}</span>@endif</a>
        <a href="{{ route('admin.hari_libur') }}" class="nav-item"><i data-lucide="calendar-off"></i> Hari Libur</a>
        <a href="{{ route('admin.lokasi') }}" class="nav-item"><i data-lucide="map-pin"></i> Lokasi Kerja</a>
        <a href="{{ route('admin.jadwal_mode') }}" class="nav-item"><i data-lucide="calendar-check"></i> Jadwal Mode Kerja</a>
        <div class="nav-label">Sistem</div>
        <a href="{{ route('admin.audit_log') }}" class="nav-item"><i data-lucide="shield-check"></i> Audit Log</a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-chip">
            <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="admin-info">
                <div class="admin-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Keluar</button>
        </form>
    </div>
</aside>

<main class="main">
    <h1 class="page-title">Kelola Karyawan</h1>
    <p class="page-sub">Tambah, lihat, dan hapus data karyawan</p>

    @if(session('success'))
        <div class="alert success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error"><i data-lucide="alert-circle"></i> {{ session('error') }}</div>
    @endif

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
</main>

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

<script>
lucide.createIcons();
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
</body>
</html>