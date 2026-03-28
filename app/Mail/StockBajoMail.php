<?php

namespace App\Mail;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockBajoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Producto $producto)
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alerta: Stock Bajo - ' . $this->producto->nombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.stock-bajo',
        );
    }
}