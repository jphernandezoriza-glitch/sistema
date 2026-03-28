<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReporteListo extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $rutaArchivo) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu reporte CSV está listo',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reporte-listo',
            with: [
                'url' => asset('storage/' . $this->rutaArchivo)
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}