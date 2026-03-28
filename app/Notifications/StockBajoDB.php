<?php

namespace App\Notifications;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StockBajoDB extends Notification
{
    use Queueable;
    public function __construct(public Producto $producto) {}
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'mensaje'     => 'Alerta de Stock Bajo: ' . $this->producto->nombre,
            'producto_id' => $this->producto->id,
            'cantidad'    => $this->producto->stock,
            'url'         => route('productos.edit', $this->producto->id),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}