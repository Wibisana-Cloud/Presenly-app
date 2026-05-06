<?php

namespace App\Policies;

use App\Models\Izin;
use App\Models\User;

class IzinPolicy
{
    /**
     * Admin dapat melihat semua izin.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Pemilik izin atau admin dapat melihat detail.
     */
    public function view(User $user, Izin $izin): bool
    {
        return $user->id === $izin->user_id || $user->role_id === 1;
    }

    /**
     * Karyawan (role_id=2) dapat membuat izin.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 2;
    }

    /**
     * Pemilik izin dapat mengedit jika masih Pending.
     */
    public function update(User $user, Izin $izin): bool
    {
        return $user->id === $izin->user_id && $izin->status === 'Pending';
    }

    /**
     * Pemilik izin dapat menghapus jika masih Pending.
     */
    public function delete(User $user, Izin $izin): bool
    {
        return $user->id === $izin->user_id && $izin->status === 'Pending';
    }

    /**
     * Admin dapat memproses (approve/reject) izin.
     */
    public function process(User $user, Izin $izin): bool
    {
        return $user->role_id === 1 && $izin->status === 'Pending';
    }
}
