<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $pengumumans = Pengumuman::with('dibuatOleh')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pengumuman', compact('pengumumans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $pengumuman = Pengumuman::create([
            'dibuat_oleh' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'is_aktif' => true,
            'published_at' => now(),
        ]);

        AuditLog::catat('Tambah Pengumuman', "Menambahkan pengumuman: {$pengumuman->judul}", 'Pengumuman', $pengumuman->id);

        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $pengumuman->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        AuditLog::catat('Edit Pengumuman', "Mengedit pengumuman: {$pengumuman->judul}", 'Pengumuman', $pengumuman->id);

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function toggleAktif(int $id): RedirectResponse
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update(['is_aktif' => ! $pengumuman->is_aktif]);

        $status = $pengumuman->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        AuditLog::catat('Toggle Pengumuman', "Pengumuman '{$pengumuman->judul}' {$status}", 'Pengumuman', $pengumuman->id);

        return back()->with('success', "Pengumuman berhasil {$status}.");
    }

    public function destroy(int $id): RedirectResponse
    {
        $pengumuman = Pengumuman::findOrFail($id);
        AuditLog::catat('Hapus Pengumuman', "Menghapus pengumuman: {$pengumuman->judul}", 'Pengumuman', $pengumuman->id);
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
