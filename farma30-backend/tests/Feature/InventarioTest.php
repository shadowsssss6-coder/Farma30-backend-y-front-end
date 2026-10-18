<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InventarioTest extends TestCase
{
    use RefreshDatabase;

    private function datosProducto(array $extra = []): array
    {
        return array_merge([
            'nombre' => 'Ibuprofeno 400 mg',
            'precio' => 8000,
            'cantidad' => 20,
            'fecha_vencimiento' => now()->addMonths(6)->toDateString(),
        ], $extra);
    }

    private function crearProducto(int $cantidad, string $vence): Producto
    {
        return Producto::create([
            'nombre' => 'Producto de prueba',
            'fecha_de_ingreso' => now()->toDateString(),
            'fecha_vencimiento' => $vence,
            'cantidad' => $cantidad,
            'precio' => 1000,
        ]);
    }

    public function test_integrante_crea_producto(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'integrante']));

        $this->postJson('/api/productos', $this->datosProducto())
            ->assertStatus(201)
            ->assertJsonPath('data.nombre', 'Ibuprofeno 400 mg');
    }

    public function test_cliente_no_puede_crear_productos(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'cliente']));

        $this->postJson('/api/productos', $this->datosProducto())->assertStatus(403);
    }

    public function test_no_se_elimina_un_producto_con_existencias(): void
    {
        $producto = $this->crearProducto(5, now()->addYear()->toDateString());
        Sanctum::actingAs(User::factory()->create(['rol' => 'administrador']));

        $this->deleteJson("/api/productos/{$producto->id}")->assertStatus(422);

        $this->assertDatabaseHas('productos', ['id' => $producto->id]);
    }

    public function test_se_elimina_un_producto_sin_existencias(): void
    {
        $producto = $this->crearProducto(0, now()->addYear()->toDateString());
        Sanctum::actingAs(User::factory()->create(['rol' => 'administrador']));

        $this->deleteJson("/api/productos/{$producto->id}")->assertOk();

        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    public function test_alertas_incluyen_solo_vencidos_y_proximos_a_vencer(): void
    {
        $this->crearProducto(5, now()->subDay()->toDateString());      // vencido
        $this->crearProducto(5, now()->addDays(10)->toDateString());   // próximo a vencer
        $this->crearProducto(5, now()->addYear()->toDateString());     // vigente
        Sanctum::actingAs(User::factory()->create(['rol' => 'integrante']));

        $this->getJson('/api/productos-alertas-vencimiento')
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_busqueda_por_nombre(): void
    {
        $this->crearProducto(5, now()->addYear()->toDateString());
        Sanctum::actingAs(User::factory()->create(['rol' => 'cliente']));

        $this->getJson('/api/productos/buscar?q=prueba')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/productos/buscar?q=inexistente')->assertOk()->assertJsonCount(0, 'data');
    }

    public function test_el_rol_administrador_se_puede_guardar(): void
    {
        $usuario = User::factory()->create(['rol' => 'administrador']);

        $this->assertSame('administrador', $usuario->fresh()->rol);
    }

    public function test_admin_seeder_crea_administrador_desde_variables_de_entorno(): void
    {
        putenv('ADMIN_EMAIL=admin@farma30.test');
        putenv('ADMIN_PASSWORD=ClaveSegura123');

        $this->seed(AdminSeeder::class);
        $this->seed(AdminSeeder::class); // idempotente

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['email' => 'admin@farma30.test', 'rol' => 'administrador']);

        putenv('ADMIN_EMAIL');
        putenv('ADMIN_PASSWORD');
    }
}
