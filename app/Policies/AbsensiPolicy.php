<?php

namespace App\Policies;

use App\Models\Absensi;
use App\Models\User;

class AbsensiPolicy
{
    /**
     * Admin dapat melihat semua absensi.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Pemilik absensi atau admin dapat melihat detail.
     */
    public function view(User $user, Absensi $absensi): bool
    {
        return $user->id === $absensi->user_id || $user->role_id === 1;
    }

    /**
     * Karyawan dapat membuat absensi sendiri.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Admin dapat mengedit absensi.
     */
    public function update(User $user, Absensi $absensi): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Admin dapat menghapus absensi.
     */
    public function delete(User $user, Absensi $absensi): bool
    {
        return $user->role_id === 1;
    }
}
