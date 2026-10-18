<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Crea (una sola vez) el administrador inicial a partir de variables de entorno.
 * No guarda credenciales en el repositorio. Es idempotente: no sobrescribe un
 * administrador ya existente.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn('ADMIN_EMAIL y ADMIN_PASSWORD no están definidos: no se creó administrador.');

            return;
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrador Farma 30',
                'password' => $password, // el cast "hashed" del modelo la encripta
                'rol' => 'administrador',
                'nombre_del_integrante' => 'Administrador Farma 30',
            ]
        );
    }
}
