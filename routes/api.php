<?php

use App\Http\Controllers\Api\ProductoApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Definición de la API con nombres de ruta protegidos para evitar colisiones
Route::apiResource('productos', ProductoApiController::class)->names([
    'index'   => 'api.productos.index',
    'store'   => 'api.productos.store',
    'show'    => 'api.productos.show',
    'update'  => 'api.productos.update',
    'destroy' => 'api.productos.destroy',
]);