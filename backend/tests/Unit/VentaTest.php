<?php

namespace Tests\Unit;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VentaTest extends TestCase
{
    use RefreshDatabase;

    public function test_registrar_una_venta_descuenta_el_inventario(): void
    {
        $integrante = User::factory()->create(['rol' => 'integrante']);
        $producto = Producto::factory()->create(['cantidad' => 10]);

        $respuesta = $this->actingAs($integrante)->postJson('/api/ventas', [
            'producto_id' => $producto->id,
            'cantidad_vendida' => 3,
            'valor_de_la_venta' => 15000,
            'metodo_de_pago' => 'efectivo',
        ]);

        $respuesta->assertStatus(201);
        $this->assertEquals(7, $producto->fresh()->cantidad);
    }

    public function test_no_permite_vender_mas_cantidad_de_la_disponible(): void
    {
        $integrante = User::factory()->create(['rol' => 'integrante']);
        $producto = Producto::factory()->create(['cantidad' => 2]);

        $respuesta = $this->actingAs($integrante)->postJson('/api/ventas', [
            'producto_id' => $producto->id,
            'cantidad_vendida' => 5,
            'valor_de_la_venta' => 15000,
            'metodo_de_pago' => 'efectivo',
        ]);

        $respuesta->assertStatus(422);
        $this->assertEquals(2, $producto->fresh()->cantidad);
    }

    public function test_un_cliente_no_puede_registrar_una_venta(): void
    {
        $cliente = User::factory()->create(['rol' => 'cliente']);
        $producto = Producto::factory()->create(['cantidad' => 10]);

        $respuesta = $this->actingAs($cliente)->postJson('/api/ventas', [
            'producto_id' => $producto->id,
            'cantidad_vendida' => 1,
            'valor_de_la_venta' => 5000,
            'metodo_de_pago' => 'efectivo',
        ]);

        $respuesta->assertStatus(403);
    }
}
