<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'rol' => 'admin'
        ]);
    }

    /** @test */
    public function un_administrador_puede_crear_un_producto(): void
    {
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post('/productos', [
                'nombre' => 'Producto de Prueba',
                'categoria_id' => $categoria->id,
                'precio' => 100,
                'stock' => 10
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('productos', [
            'nombre' => 'Producto de Prueba'
        ]);
    }

    /** @test */
    public function test_puede_ver_listado_de_productos(): void 
    {
        Producto::factory(5)->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertSee('productos');
    }

    /** @test */
    public function test_admin_puede_crear_producto(): void 
    {
        $categoria = Categoria::factory()->create();
        $data = Producto::factory()->make([
            'categoria_id' => $categoria->id
        ])->toArray();

        $response = $this->actingAs($this->admin)
                         ->post(route('productos.web.store'), $data);

        $response->assertRedirect(route('productos.index'));

        $this->assertDatabaseHas('productos', [
            'nombre' => $data['nombre']
        ]);
    }

    /** @test */
    public function test_no_puede_crear_producto_sin_nombre(): void 
    {
        $response = $this->actingAs($this->admin)
                         ->post(route('productos.web.store'), ['precio' => 100]);

        $response->assertSessionHasErrors('nombre');
    }

    /** @test */
    public function test_usuario_normal_no_puede_crear_producto(): void 
    {
        $user = User::factory()->create(['rol' => 'usuario']);
        
        $categoria = Categoria::factory()->create();
        $data = Producto::factory()->make([
            'categoria_id' => $categoria->id
        ])->toArray();

        $response = $this->actingAs($user)
                         ->post(route('productos.web.store'), $data);

        $response->assertStatus(403);
    }
}