<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'user_id', 'tanggal', 'jam_masuk', 'jam_pulang',
        'latitude_absen', 'longitude_absen',
        'jarak_meter', 'status', 'durasi_kerja',
        'mode_kerja',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
