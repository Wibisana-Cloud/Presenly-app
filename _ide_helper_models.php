<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $tanggal
 * @property string|null $jam_masuk
 * @property string|null $jam_pulang
 * @property numeric|null $latitude_absen
 * @property numeric|null $longitude_absen
 * @property float|null $jarak_meter
 * @property string|null $status
 * @property string $mode_kerja
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $durasi_kerja
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereDurasiKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereJamPulang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereJarakMeter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereLatitudeAbsen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereLongitudeAbsen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereModeKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereUserId($value)
 */
	class Absensi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $aksi
 * @property string $deskripsi
 * @property string|null $model_type
 * @property int|null $model_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserId($value)
 */
	class AuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string $nama
 * @property string $tipe
 * @property bool $is_manual
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereIsManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereUpdatedAt($value)
 */
	class HariLibur extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $tanggal_mulai
 * @property \Illuminate\Support\Carbon $tanggal_selesai
 * @property string $jenis_izin
 * @property string $keterangan
 * @property string|null $lampiran
 * @property string $status
 * @property string|null $catatan_admin
 * @property int|null $diproses_oleh
 * @property \Illuminate\Support\Carbon|null $diproses_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $durasi
 * @property-read \App\Models\User|null $prosesOleh
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereCatatanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereDiprosesAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereDiprosesOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereJenisIzin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereLampiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereUserId($value)
 */
	class Izin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_lokasi
 * @property numeric $latitude
 * @property numeric $longitude
 * @property int $radius_meter
 * @property string $jam_masuk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereNamaLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereRadiusMeter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LokasiKerja whereUpdatedAt($value)
 */
	class LokasiKerja extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

