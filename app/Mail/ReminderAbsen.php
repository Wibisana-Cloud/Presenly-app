<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderAbsen extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public \App\Models\User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Presenly] Reminder: Jangan Lupa Absen Hari Ini!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reminder-absen',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
