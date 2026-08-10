<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::updateOrCreate(
            ['email' => 'admin@farma30.com'],
            [
                'name' => 'Administrador Farma 30',
                'password' => bcrypt('admin1234'),
                'rol' => 'administrador',
                'nombre_del_integrante' => 'Administrador Farma 30',
            ]
        );
    }
}
