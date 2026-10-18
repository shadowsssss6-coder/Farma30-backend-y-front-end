<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VentasTest extends TestCase
{
    use RefreshDatabase;

    private function producto(int $cantidad = 10): Producto
    {
        return Producto::create([
            'nombre' => 'Acetaminofén 500 mg',
            'fecha_de_ingreso' => now()->toDateString(),
            'fecha_vencimiento' => now()->addYear()->toDateString(),
            'cantidad' => $cantidad,
            'precio' => 5000,
        ]);
    }

    private function datosVenta(Producto $producto, int $cantidad = 2): array
    {
        return [
            'producto_id' => $producto->id,
            'cantidad_vendida' => $cantidad,
            'valor_de_la_venta' => 10000,
            'metodo_de_pago' => 'efectivo',
        ];
    }

    public function test_integrante_registra_venta_y_se_descuenta_inventario(): void
    {
        $producto = $this->producto(10);
        Sanctum::actingAs(User::factory()->create(['rol' => 'integrante']));

        $this->postJson('/api/ventas', $this->datosVenta($producto, 3))->assertCreated();

        $this->assertSame(7, $producto->fresh()->cantidad);
        $this->assertDatabaseCount('ventas', 1);
    }

    public function test_no_se_puede_vender_mas_de_lo_que_hay(): void
    {
        $producto = $this->producto(2);
        Sanctum::actingAs(User::factory()->create(['rol' => 'integrante']));

        $this->postJson('/api/ventas', $this->datosVenta($producto, 5))->assertStatus(422);

        $this->assertSame(2, $producto->fresh()->cantidad);
        $this->assertDatabaseCount('ventas', 0);
    }

    public function test_cliente_no_puede_registrar_ventas(): void
    {
        $producto = $this->producto();
        Sanctum::actingAs(User::factory()->create(['rol' => 'cliente']));

        $this->postJson('/api/ventas', $this->datosVenta($producto))->assertStatus(403);
    }

    public function test_metodo_de_pago_invalido_es_rechazado(): void
    {
        $producto = $this->producto();
        Sanctum::actingAs(User::factory()->create(['rol' => 'integrante']));

        $this->postJson('/api/ventas', array_merge($this->datosVenta($producto), ['metodo_de_pago' => 'cheque']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('metodo_de_pago');
    }

    public function test_cliente_no_puede_ver_detalle_ni_resumen_de_ventas(): void
    {
        $producto = $this->producto();
        $integrante = User::factory()->create(['rol' => 'integrante']);
        $venta = Venta::create([
            'producto_id' => $producto->id,
            'integrante_id' => $integrante->id,
            'valor_de_la_venta' => 10000,
            'cantidad_vendida' => 2,
            'metodo_de_pago' => 'efectivo',
        ]);

        Sanctum::actingAs(User::factory()->create(['rol' => 'cliente']));

        $this->getJson("/api/ventas/{$venta->id}")->assertStatus(403);
        $this->getJson('/api/ventas/resumen')->assertStatus(403);
    }

    public function test_integrante_ve_el_resumen_de_ventas(): void
    {
        $producto = $this->producto();
        Sanctum::actingAs(User::factory()->create(['rol' => 'integrante']));

        $this->postJson('/api/ventas', $this->datosVenta($producto, 4))->assertCreated();

        $this->getJson('/api/ventas/resumen')
            ->assertOk()
            ->assertJsonPath('cantidad_vendida_en_el_dia', 4)
            ->assertJsonPath('cantidad_vendida_en_el_mes', 4);
    }
}
