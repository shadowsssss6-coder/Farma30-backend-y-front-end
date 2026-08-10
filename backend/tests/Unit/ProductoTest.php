<?php

namespace Tests\Unit;

use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_producto_vencido_se_detecta_correctamente(): void
    {
        $producto = Producto::factory()->create([
            'fecha_vencimiento' => now()->subDay(),
        ]);

        $this->assertTrue($producto->estaVencido());
    }

    public function test_un_producto_proximo_a_vencer_se_detecta_correctamente(): void
    {
        $producto = Producto::factory()->create([
            'fecha_vencimiento' => now()->addDays(10),
        ]);

        $this->assertTrue($producto->estaProximoAVencer(30));
        $this->assertFalse($producto->estaProximoAVencer(5));
    }

    public function test_no_se_puede_eliminar_un_producto_con_existencias(): void
    {
        $integrante = \App\Models\User::factory()->create(['rol' => 'integrante']);
        $producto = Producto::factory()->create(['cantidad' => 5]);

        $respuesta = $this->actingAs($integrante)->deleteJson("/api/productos/{$producto->id}");

        $respuesta->assertStatus(422);
        $this->assertDatabaseHas('productos', ['id' => $producto->id]);
    }
}
