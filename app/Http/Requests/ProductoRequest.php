<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitimos la validación para todos los usuarios
    }

    public function rules(): array
    {
        return [
            'nombre'       => 'required|string|max:100|unique:productos,nombre,' . ($this->producto ? $this->producto->id : ''),
            'precio'       => 'required|numeric|min:0.01',
            'stock'        => 'required|integer|min:0',
            'descripcion'  => 'nullable|string|max:500',
            'categoria_id' => 'required|exists:categorias,id', // <-- Validación de integridad
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'      => 'El nombre del producto es obligatorio.',
            'nombre.unique'        => 'Ya existe un producto con ese nombre.',
            'precio.required'      => 'El precio es obligatorio.',
            'precio.min'           => 'El precio debe ser al menos 0.01.',
            'stock.required'       => 'El stock inicial es obligatorio.',
            'stock.integer'        => 'El stock debe ser un número entero.',
            'stock.min'            => 'El stock no puede ser menor a cero.',
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists'   => 'La categoría seleccionada no es válida.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'       => 'nombre del producto',
            'precio'       => 'precio',
            'stock'        => 'stock inicial',
            'descripcion'  => 'descripción',
            'categoria_id' => 'categoría',
        ];
    }
}