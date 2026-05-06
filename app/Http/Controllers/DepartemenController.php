<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Departemen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $departemens = Departemen::withCount('karyawan')->orderBy('nama')->get();

        return view('admin.departemen', compact('departemens'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:departemens,nama',
            'kode' => 'nullable|string|max:20|unique:departemens,kode',
            'deskripsi' => 'nullable|string',
        ]);

        $dep = Departemen::create($request->only('nama', 'kode', 'deskripsi'));
        AuditLog::catat('Tambah Departemen', "Menambahkan departemen: {$dep->nama}", 'Departemen', $dep->id);

        return back()->with('success', "Departemen {$dep->nama} berhasil ditambahkan.");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $dep = Departemen::findOrFail($id);

        $request->validate([
            'nama' => "required|string|max:100|unique:departemens,nama,{$id}",
            'kode' => "nullable|string|max:20|unique:departemens,kode,{$id}",
            'deskripsi' => 'nullable|string',
        ]);

        $dep->update($request->only('nama', 'kode', 'deskripsi'));
        AuditLog::catat('Edit Departemen', "Mengedit departemen: {$dep->nama}", 'Departemen', $dep->id);

        return back()->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $dep = Departemen::findOrFail($id);
        AuditLog::catat('Hapus Departemen', "Menghapus departemen: {$dep->nama}", 'Departemen', $dep->id);
        $dep->delete();

        return back()->with('success', 'Departemen berhasil dihapus.');
    }

    public function assignKaryawan(Request $request, int $userId): RedirectResponse
    {
        $request->validate(['departemen_id' => 'nullable|exists:departemens,id']);

        \App\Models\User::where('role_id', 2)->findOrFail($userId)
            ->update(['departemen_id' => $request->departemen_id]);

        return back()->with('success', 'Departemen karyawan berhasil diperbarui.');
    }
}
