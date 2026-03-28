<?php

namespace App\Listeners;

use App\Events\ProductoGuardado;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegistrarActividad
{
    public function __construct()
    {
        
    }

    public function handle(ProductoGuardado $event): void
    {
        ActivityLog::create([
            'accion'      => $event->accion,
            'modelo'      => 'Producto',
            'modelo_id'   => $event->producto->id,
            'descripcion' => 'Producto ' . $event->accion . ': ' . $event->producto->nombre,
            'user_id'     => $event->usuario?->id ?? auth()->id(),
        ]);
    }
}