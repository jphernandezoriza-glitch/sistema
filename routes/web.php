<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('productos', ProductoController::class)->names([
        'store'  => 'productos.web.store',
        'update' => 'productos.web.update',
    ]);

    Route::get('productos-reporte-pdf', [ProductoController::class, 'generarPdf'])->name('reportes.pdf');
    Route::get('productos-reporte-excel', [ProductoController::class, 'generarExcel'])->name('reportes.excel');
    Route::post('/reportes/csv', [ProductoController::class, 'exportarCsv'])->name('reportes.csv');

    Route::get('/actividad', function() {
        $logs = ActivityLog::with('user')->latest()->take(50)->get();
        return view('actividad.index', compact('logs'));
    })->name('actividad.index');
    
    Route::post('/notificaciones/leer', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Notificaciones marcadas como leídas');
    })->name('notificaciones.leer');

    
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::get('/carrito-vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
});

require __DIR__.'/auth.php';