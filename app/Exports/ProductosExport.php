<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{

    public function collection()
    {
        return Producto::with('categoria')->orderBy('nombre')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Categoría',
            'Precio',
            'Stock',
            'Fecha de Creación',
        ];
    }

    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->nombre,
            $producto->categoria->nombre ?? 'Sin categoría',
            '$' . number_format($producto->precio, 2),
            $producto->stock,
            $producto->created_at->format('d/m/Y'),
        ];
    }
}