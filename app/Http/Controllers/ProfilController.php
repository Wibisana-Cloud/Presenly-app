<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik keseluruhan
        $totalAbsensi = Absensi::where('user_id', $user->id)->count();
        $totalHadir = Absensi::where('user_id', $user->id)->where('status', 'Hadir')->count();
        $totalTerlambat = Absensi::where('user_id', $user->id)->where('status', 'Terlambat')->count();
        $totalAlfa = Absensi::where('user_id', $user->id)->where('status', 'Alfa')->count();
        $totalIzin = Absensi::where('user_id', $user->id)->where('status', 'Izin')->count();

        // Absensi pertama (bergabung sejak)
        $absensiPertama = Absensi::where('user_id', $user->id)->orderBy('tanggal', 'asc')->first();

        // Bulan ini
        $bulanIni = Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        return view('profil', compact(
            'user',
            'totalAbsensi', 'totalHadir', 'totalTerlambat', 'totalAlfa', 'totalIzin',
            'absensiPertama', 'bulanIni'
        ));
    }

    // Update nama & email
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
        ]);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Ganti password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (! Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
