<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'dibuat_oleh',
        'judul',
        'isi',
        'is_aktif',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_aktif' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function dibuatOleh(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function scopeAktif($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_aktif', true);
    }
}
