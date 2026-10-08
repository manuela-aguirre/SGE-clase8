<?php

namespace Tests\Feature;

use App\Models\Proveedor;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_books_index_handles_missing_relations(): void
    {
        $user = User::factory()->create();
        $proveedor = Proveedor::create(['nombre' => 'Proveedor de prueba']);
        $categoria = Category::create(['nombre' => 'Categoría de prueba']);

        $producto = Product::create([
            'nombre' => 'Producto sin proveedor ni categoría',
            'descripcion' => 'Debe renderizar sin romper la vista.',
            'stock' => 4,
            'codigo' => '9780000000000',
            'proveedor_id' => $proveedor->id,
            'categoria_id' => $categoria->id,
        ]);

        $producto->setRelation('proveedor', null);
        $producto->setRelation('categoria', null);

        $this->actingAs($user)
            ->view('productos.index', [
                'productos' => new LengthAwarePaginator([$producto], 1, 15),
                'q' => null,
            ])
            ->assertSee('Sin proveedor')
            ->assertSee('Sin categoría');
    }

    public function test_dashboard_shows_practical_kpis_for_analysis(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Ventas por cobrar')
            ->assertSee('Stock crítico')
            ->assertSee('Tasa de mora')
            ->assertSee('Rotación de productos')
            ->assertSee('Cartera pendiente');
    }
}
