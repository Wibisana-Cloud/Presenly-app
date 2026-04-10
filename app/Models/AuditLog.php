<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
        'model_type',
        'model_id',
    ];

    /**
     * Log an action performed by the currently authenticated user.
     */
    public static function catat(string $aksi, string $deskripsi, ?string $modelType = null, ?int $modelId = null): void
    {
        static::create([
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'model_type' => $modelType,
            'model_id' => $modelId,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
