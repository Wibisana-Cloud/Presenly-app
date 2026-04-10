<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiKerja extends Model
{
    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius_meter',
        'jam_masuk',
    ];
}
