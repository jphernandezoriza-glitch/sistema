<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\User;
use App\Http\Resources\ProductoResource;
use App\Events\ProductoGuardado;
use Illuminate\Http\Request;
use App\Mail\StockBajoMail;
use App\Notifications\StockBajoDB;
use Illuminate\Support\Facades\Mail;

class ProductoApiController extends Controller
{
    public function index()
    {
        return ProductoResource::collection(Producto::paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock'  => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $producto = Producto::create($data);

        event(new ProductoGuardado($producto, 'creado', auth()->user()));

        if ($producto->stock < 5) {
            Mail::to('admin@uptex.edu.mx')->send(new StockBajoMail($producto));

            $admin = User::where('rol', 'admin')->first(); 
            if ($admin) {
                $admin->notify(new StockBajoDB($producto));
            }
        }

        return (new ProductoResource($producto))
                ->response()
                ->setStatusCode(201);
    }

    public function show(Producto $producto)
    {
        return new ProductoResource($producto);
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock'  => 'required|integer',
        ]);

        $producto->update($data);

        event(new ProductoGuardado($producto, 'actualizado', auth()->user()));

        if ($producto->fresh()->stock < 5) {
            Mail::to('admin@uptex.edu.mx')->send(new StockBajoMail($producto));

            $admin = User::where('rol', 'admin')->first();
            if ($admin) {
                $admin->notify(new StockBajoDB($producto));
            }
        }

        return new ProductoResource($producto);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json([
            'message' => 'Producto eliminado correctamente.'
        ], 200);
    }
}