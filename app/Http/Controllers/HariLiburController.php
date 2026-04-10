<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HariLiburController extends Controller
{
    // ── ADMIN: Tampilkan semua hari libur ──
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $hariLibur = HariLibur::whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $tahunList = collect(range(now()->year - 1, now()->year + 1));

        return view('admin.hari_libur', compact('hariLibur', 'tahun', 'tahunList'));
    }

    // ── ADMIN: Sinkronisasi dari API ──
    public function sinkronisasi(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        try {
            $response = Http::timeout(10)
                ->get("https://api-harilibur.vercel.app/api?year={$tahun}");

            if (! $response->successful()) {
                return back()->with('error', 'Gagal mengambil data dari API. Coba lagi!');
            }

            $data = $response->json();
            $count = 0;

            foreach ($data as $item) {
                // Skip hari Minggu biasa (API kadang ikutkan)
                if (empty($item['holiday_name'])) {
                    continue;
                }

                HariLibur::updateOrCreate(
                    ['tanggal' => $item['holiday_date']],
                    [
                        'nama' => $item['holiday_name'],
                        'tipe' => 'nasional',
                        'is_manual' => false,
                    ]
                );
                $count++;
            }

            return back()->with('success', "Berhasil sinkronisasi {$count} hari libur nasional tahun {$tahun}!");

        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi ke API gagal: '.$e->getMessage());
        }
    }

    // ── ADMIN: Tambah hari libur manual ──
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:hari_libur,tanggal',
            'nama' => 'required|string|max:100',
        ], [
            'tanggal.unique' => 'Tanggal ini sudah terdaftar sebagai hari libur.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'nama.required' => 'Nama hari libur wajib diisi.',
        ]);

        HariLibur::create([
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'tipe' => 'manual',
            'is_manual' => true,
        ]);

        return back()->with('success', 'Hari libur berhasil ditambahkan!');
    }

    // ── ADMIN: Hapus hari libur ──
    public function destroy($id)
    {
        $hariLibur = HariLibur::findOrFail($id);
        $hariLibur->delete();

        return back()->with('success', 'Hari libur berhasil dihapus!');
    }
}
