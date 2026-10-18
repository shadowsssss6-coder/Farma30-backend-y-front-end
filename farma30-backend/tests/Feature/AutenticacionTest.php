<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AutenticacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_puede_registrarse_y_recibe_token(): void
    {
        $respuesta = $this->postJson('/api/auth/registro', [
            'email' => 'cliente@correo.com',
            'password' => 'clave12345',
            'numero_de_contacto' => '3001234567',
        ]);

        $respuesta->assertStatus(201)
            ->assertJsonStructure(['token', 'usuario' => ['id', 'email', 'rol']])
            ->assertJsonPath('usuario.rol', 'cliente');
    }

    public function test_registro_publico_no_permite_crear_integrantes(): void
    {
        $this->postJson('/api/auth/registro', [
            'email' => 'intruso@correo.com',
            'password' => 'clave12345',
            'rol' => 'integrante',
            'nombre_del_integrante' => 'Intruso',
            'numero_de_contacto' => '3000000000',
        ])->assertStatus(422)->assertJsonValidationErrors('rol');

        $this->assertDatabaseMissing('users', ['email' => 'intruso@correo.com']);
    }

    public function test_login_correcto_devuelve_token(): void
    {
        User::factory()->create(['email' => 'a@a.com', 'password' => 'clave12345']);

        $this->postJson('/api/auth/login', ['email' => 'a@a.com', 'password' => 'clave12345'])
            ->assertOk()
            ->assertJsonStructure(['token', 'usuario']);
    }

    public function test_login_con_clave_incorrecta_falla(): void
    {
        User::factory()->create(['email' => 'a@a.com', 'password' => 'clave12345']);

        $this->postJson('/api/auth/login', ['email' => 'a@a.com', 'password' => 'otraclave99'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_rutas_protegidas_exigen_token(): void
    {
        $this->getJson('/api/productos')->assertStatus(401);
    }

    public function test_solo_administrador_puede_crear_integrantes(): void
    {
        $datos = [
            'email' => 'nuevo@farma30.com',
            'password' => 'clave12345',
            'nombre_del_integrante' => 'Nuevo Integrante',
        ];

        Sanctum::actingAs(User::factory()->create(['rol' => 'cliente']));
        $this->postJson('/api/usuarios/integrantes', $datos)->assertStatus(403);

        Sanctum::actingAs(User::factory()->create(['rol' => 'administrador']));
        $this->postJson('/api/usuarios/integrantes', $datos)
            ->assertStatus(201)
            ->assertJsonPath('data.rol', 'integrante');
    }

    public function test_cerrar_sesion_revoca_el_token(): void
    {
        $usuario = User::factory()->create(['password' => 'clave12345']);
        $token = $usuario->createToken('prueba')->plainTextToken;

        $this->withToken($token)->postJson('/api/auth/logout')->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
