<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::factory(50)->create([
            'categoria_id' => fn() => Categoria::inRandomOrder()->first()->id,
        ]);
    }
}