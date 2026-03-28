<?php

namespace App\Events;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class ProductoGuardado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Producto $producto,
        public string   $accion,
        public ?User    $usuario = null
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}