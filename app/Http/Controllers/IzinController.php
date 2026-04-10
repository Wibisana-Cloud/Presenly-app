<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Izin;
use App\Models\User;
use App\Notifications\IzinDiprosesNotification;
use App\Notifications\IzinPendingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    // ── KARYAWAN: Lihat & ajukan izin ──
    public function index()
    {
        $izins = Izin::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('izin', compact('izins'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_id !== 2) {
            return back()->with('error', 'Hanya karyawan yang dapat mengajukan izin.');
        }

        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_izin' => 'required|in:Sakit,Cuti,Keperluan',
            'keterangan' => 'required|string|max:500',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Cek apakah sudah ada pengajuan pending/disetujui di rentang tanggal sama
        $existing = Izin::where('user_id', Auth::id())
            ->whereIn('status', ['Pending', 'Disetujui'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai]);
            })->first();

        if ($existing) {
            return back()->with('error', 'Sudah ada pengajuan izin di rentang tanggal tersebut!');
        }

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('izin-lampiran', 'public');
        }

        $izin = Izin::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_izin' => $request->jenis_izin,
            'keterangan' => $request->keterangan,
            'lampiran' => $lampiranPath,
            'status' => 'Pending',
        ]);

        // Kirim notifikasi email ke semua admin
        $admins = User::where('role_id', 1)->get();
        Notification::send($admins, new IzinPendingNotification($izin->load('user')));

        return back()->with('success', 'Pengajuan izin berhasil dikirim! Menunggu persetujuan admin.');
    }

    public function destroy($id)
    {
        $izin = Izin::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($izin->status !== 'Pending') {
            return back()->with('error', 'Izin yang sudah diproses tidak bisa dibatalkan.');
        }

        if ($izin->lampiran) {
            Storage::disk('public')->delete($izin->lampiran);
        }

        $izin->delete();

        return back()->with('success', 'Pengajuan izin berhasil dibatalkan.');
    }

    // ── ADMIN: Kelola semua izin ──
    public function adminIndex(Request $request)
    {
        $query = Izin::with('user')->orderBy('created_at', 'desc');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->jenis) {
            $query->where('jenis_izin', $request->jenis);
        }

        $izins = $query->paginate(15);
        $totalPending = Izin::where('status', 'Pending')->count();
        $totalDisetujui = Izin::where('status', 'Disetujui')->count();
        $totalDitolak = Izin::where('status', 'Ditolak')->count();

        return view('admin.izin', compact('izins', 'totalPending', 'totalDisetujui', 'totalDitolak'));
    }

    public function approve(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        $izin->update([
            'status' => 'Disetujui',
            'catatan_admin' => $request->catatan_admin,
            'diproses_oleh' => Auth::id(),
            'diproses_at' => now(),
        ]);

        AuditLog::catat('Setujui Izin', "Menyetujui izin {$izin->jenis_izin} milik {$izin->user->name}", 'Izin', $izin->id);

        $izin->user->notify(new IzinDiprosesNotification($izin));

        return back()->with('success', "Izin {$izin->user->name} berhasil disetujui.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:300',
        ]);

        $izin = Izin::findOrFail($id);

        $izin->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->catatan_admin,
            'diproses_oleh' => Auth::id(),
            'diproses_at' => now(),
        ]);

        AuditLog::catat('Tolak Izin', "Menolak izin {$izin->jenis_izin} milik {$izin->user->name}. Alasan: {$request->catatan_admin}", 'Izin', $izin->id);

        $izin->user->notify(new IzinDiprosesNotification($izin));

        return back()->with('success', "Izin {$izin->user->name} berhasil ditolak.");
    }
}
