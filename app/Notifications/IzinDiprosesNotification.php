<?php

namespace App\Notifications;

use App\Models\Izin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IzinDiprosesNotification extends Notification
{
    use Queueable;

    public function __construct(public Izin $izin) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $disetujui = $this->izin->status === 'Disetujui';
        $tanggalMulai = $this->izin->tanggal_mulai->translatedFormat('d F Y');
        $tanggalSelesai = $this->izin->tanggal_selesai->translatedFormat('d F Y');
        $periode = $tanggalMulai !== $tanggalSelesai
            ? "{$tanggalMulai} s.d. {$tanggalSelesai}"
            : $tanggalMulai;

        $mail = (new MailMessage)
            ->subject('[Presenly] Pengajuan Izin '.($disetujui ? 'Disetujui' : 'Ditolak'))
            ->greeting('Halo, '.$notifiable->name.'!')
            ->line($disetujui
                ? 'Pengajuan izin Anda telah **disetujui** oleh admin.'
                : 'Mohon maaf, pengajuan izin Anda **ditolak** oleh admin.'
            )
            ->line("**Jenis Izin:** {$this->izin->jenis_izin}")
            ->line("**Periode:** {$periode}");

        if ($this->izin->catatan_admin) {
            $mail->line("**Catatan Admin:** {$this->izin->catatan_admin}");
        }

        return $mail
            ->action('Lihat Detail Izin', route('izin.index'))
            ->line($disetujui
                ? 'Semoga cepat pulih dan segera kembali bekerja!'
                : 'Silakan hubungi admin jika ada pertanyaan lebih lanjut.'
            );
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
