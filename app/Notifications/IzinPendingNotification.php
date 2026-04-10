<?php

namespace App\Notifications;

use App\Models\Izin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IzinPendingNotification extends Notification
{
    use Queueable;

    public function __construct(public Izin $izin) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $karyawan = $this->izin->user;
        $tanggalMulai = \Carbon\Carbon::parse($this->izin->tanggal_mulai)->translatedFormat('d F Y');
        $tanggalSelesai = \Carbon\Carbon::parse($this->izin->tanggal_selesai)->translatedFormat('d F Y');
        $urlIzin = route('admin.izin');

        return (new MailMessage)
            ->subject("[Presenly] Pengajuan Izin Baru – {$karyawan->name}")
            ->greeting('Halo, Admin!')
            ->line("**{$karyawan->name}** mengajukan izin baru yang memerlukan persetujuan Anda.")
            ->line("**Jenis Izin:** {$this->izin->jenis_izin}")
            ->line("**Tanggal:** {$tanggalMulai}".($tanggalMulai !== $tanggalSelesai ? " s.d. {$tanggalSelesai}" : ''))
            ->line("**Keterangan:** {$this->izin->keterangan}")
            ->action('Lihat & Proses Izin', $urlIzin)
            ->line('Silakan setujui atau tolak pengajuan tersebut melalui dashboard admin.');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
