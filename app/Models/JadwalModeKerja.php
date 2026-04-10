<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalModeKerja extends Model
{
    protected $fillable = [
        'tanggal',
        'mode',
        'keterangan',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /**
     * Ambil mode kerja untuk tanggal tertentu (default WFO).
     */
    public static function modeUntukTanggal(string $tanggal): string
    {
        $jadwal = static::where('tanggal', $tanggal)->first();

        return $jadwal?->mode ?? 'WFO';
    }
}
