<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use App\Notifications\ProductoCreado;
use App\Notifications\StockBajoDB;
use App\Events\ProductoGuardado;
use Illuminate\Http\Request;
use App\Mail\StockBajoMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\GenerarReporteCsv;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
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

        

        if (auth()->user()->rol !== 'admin') {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        if ($producto->stock <= 5) {
            auth()->user()->notify(new StockBajoDB($producto));
        }

        return redirect()->route('productos.index')->with('success', 'Guardado con éxito');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $producto->update($data);

        event(new ProductoGuardado($producto, 'actualizado', auth()->user()));

        if ($producto->fresh()->stock <= 5) { 
            $admin = User::where('rol', 'admin')->first() ?: User::first();
            
            if ($admin) {
                $admin->notify(new StockBajoDB($producto));
            }
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function generarPdf()
    {
        $productos = Producto::all();
        $pdf = Pdf::loadView('reportes.productos', compact('productos'));
        return $pdf->download('reporte_productos.pdf');
    }

    public function generarExcel()
    {
        return Excel::download(new ProductosExport, 'reporte_productos.xlsx');
    }


    public function exportarCsv(Request $request) 
    {
        $filtro = $request->input('search', '');

        GenerarReporteCsv::dispatch(auth()->user(), $filtro)
            ->onQueue('reportes');

        return back()->with('success', 'El reporte se está generando. Recibirás un correo en breve con el enlace de descarga.');
    }
}