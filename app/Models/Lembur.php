<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lemburans';

    protected $fillable = [
        'user_id',
        'absensi_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'durasi_lembur',
        'keterangan',
        'status',
        'diproses_oleh',
        'diproses_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'diproses_at' => 'datetime',
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function absensi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Absensi::class);
    }

    public function diprosesOleh(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
