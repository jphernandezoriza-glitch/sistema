<?php

namespace App\Providers;

use App\Events\ProductoGuardado;
use App\Listeners\RegistrarActividad;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
        \App\Events\ProductoGuardado::class,
        \App\Listeners\RegistrarActividad::class,
        );
    }
}