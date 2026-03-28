<?php

namespace App\Notifications;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductoCreado extends Notification
{
    use Queueable;
    public function __construct(public Producto $producto)
    {
    }
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'mensaje'     => 'Se registro el producto: ' . $this->producto->nombre,
            'producto_id' => $this->producto->id,
            'precio'      => $this->producto->precio,
            'url'         => route('productos.show', $this->producto->id),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}