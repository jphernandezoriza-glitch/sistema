<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        
        return view('carrito.index', compact('carrito'));
    }

    public function agregar(Request $request, Producto $producto)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad']++;
        } else {
            $carrito[$producto->id] = [
                'producto_id' => $producto->id,
                'nombre'      => $producto->nombre,
                'precio'      => $producto->precio,
                'cantidad'    => 1,
            ];
        }

        session()->put('carrito', $carrito);

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function actualizar(Request $request, $id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = max(1, (int)$request->cantidad);
            session()->put('carrito', $carrito);
        }

        return back();
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        unset($carrito[$id]);

        session()->put('carrito', $carrito);

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');

        return redirect()->route('carrito.index');
    }
}