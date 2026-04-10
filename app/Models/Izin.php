<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_izin',
        'keterangan',
        'lampiran',
        'status',
        'catatan_admin',
        'diproses_oleh',
        'diproses_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'diproses_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function getDurasiAttribute(): int
    {
        $hariLibur = HariLibur::whereBetween('tanggal', [
            $this->tanggal_mulai->toDateString(),
            $this->tanggal_selesai->toDateString(),
        ])->pluck('tanggal')
            ->map(fn ($t) => Carbon::parse($t)->toDateString())
            ->all();

        $durasi = 0;
        $current = $this->tanggal_mulai->copy();

        while ($current->lte($this->tanggal_selesai)) {
            if (! $current->isWeekend() && ! in_array($current->toDateString(), $hariLibur)) {
                $durasi++;
            }

            $current->addDay();
        }

        return $durasi;
    }
}
