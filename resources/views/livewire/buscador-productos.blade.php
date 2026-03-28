<?php

use App\Models\Producto;
use function Livewire\Volt\{state, with};

state(['busqueda' => '']);

with(fn () => [
    'productos' => Producto::when($this->busqueda, function($query) {
        $query->where('nombre', 'LIKE', '%' . $this->busqueda . '%')
              ->orWhere('descripcion', 'LIKE', '%' . $this->busqueda . '%');
    })
    ->limit(10)
    ->get(),
]);

?>

<div class="p-4 bg-white shadow-sm rounded-lg border border-gray-200">
    <div class="mb-4">
        <label class="block text-sm font-bold text-gray-700 mb-2">Buscador de Inventario</label>
        <input 
            wire:model.live="busqueda" 
            type="text" 
            class="w-full p-2 border border-blue-300 rounded-md focus:ring-2 focus:ring-blue-500 outline-none shadow-sm" 
            placeholder="Escribe el nombre del producto..."
        >
        
        <div wire:loading class="text-xs text-blue-600 mt-1 animate-pulse">
            Buscando en la base de datos de UPTex...
        </div>
    </div>

    <div class="divide-y divide-gray-100 bg-white rounded-md">
        @foreach($productos as $p)
            <div class="py-3 px-2 flex justify-between items-center hover:bg-gray-50 transition first:rounded-t-md last:rounded-b-md">
                <div>
                    <p class="font-semibold text-gray-800">{{ $p->nombre }}</p>
                    <p class="text-xs text-gray-500">{{ Str::limit($p->descripcion, 50) }}</p>
                </div>
                <div class="text-right">
                    <span class="text-green-600 font-bold text-lg">${{ number_format($p->precio, 2) }}</span>
                    <p class="text-xs text-gray-400">Stock: {{ $p->stock }}</p>
                </div>
            </div>
        @endforeach

        @if($productos->isEmpty() && $busqueda != '')
            <div class="py-4 text-center">
                <p class="text-red-500 font-medium italic">No se encontraron coincidencias para "{{ $busqueda }}"</p>
            </div>
        @elseif($productos->isEmpty() && $busqueda == '')
            <div class="py-4 text-center">
                <p class="text-gray-400 text-sm italic">Comienza a escribir para buscar productos...</p>
            </div>
        @endif
    </div>
</div>