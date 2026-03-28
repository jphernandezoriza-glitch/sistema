<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Producto;
use App\Mail\ReporteListo;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerarReporteCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        public User $usuario,
        public ?string $filtro = ''
    ) {}

    public function handle(): void
    {
        // Obtener los productos con su categoria
        $query = Producto::with('categoria');

        // Aplicar filtro
        if ($this->filtro) {
            $query->where('nombre', 'LIKE', '%' . $this->filtro . '%');
        }

        $productos = $query->get();

        // Generar el contenido del CSV en memoria
        $csv = "ID,Nombre,Categoria,Precio,Stock\n";
        foreach ($productos as $p) {
            $csv .= implode(',', [
                $p->id,
                $p->nombre,
                $p->categoria->nombre ?? 'Sin categora',
                $p->precio,
                $p->stock
            ]) . "\n";
        }

        // Guardar el archivo en el disco publico
        $nombreArchivo = 'reportes/productos-' . now()->format('Ymd-His') . '.csv';
        Storage::disk('public')->put($nombreArchivo, $csv);

        // Enviar por correo
        Mail::to($this->usuario)->send(new ReporteListo($nombreArchivo));
    }
}