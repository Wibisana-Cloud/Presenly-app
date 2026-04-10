<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'hari_libur';

    protected $fillable = [
        'tanggal',
        'nama',
        'tipe',
        'is_manual',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_manual' => 'boolean',
    ];

    // Cek apakah tanggal tertentu adalah hari libur
    public static function isLibur($tanggal): bool
    {
        return self::where('tanggal', $tanggal)->exists();
    }

    // Ambil nama hari libur
    public static function namaLibur($tanggal): ?string
    {
        return self::where('tanggal', $tanggal)->value('nama');
    }
}
