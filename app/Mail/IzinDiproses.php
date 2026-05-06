<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IzinDiproses extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public \App\Models\Izin $izin) {}

    public function envelope(): Envelope
    {
        $status = $this->izin->status === 'Disetujui' ? '✅ Disetujui' : '❌ Ditolak';

        return new Envelope(
            subject: "[Presenly] Izin Kamu {$status}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.izin-diproses',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
