<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    
    {
            return [
            'nombre'       => fake()->unique()->words(3, true),
            'descripcion'  => fake()->paragraph(2),
            'precio'       => fake()->randomFloat(2, 10, 5000),
            'stock'        => fake()->numberBetween(0, 200),
            'categoria_id' => \App\Models\Categoria::factory(),
            ];
    }
}
