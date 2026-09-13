<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Añade 'administrador' al enum de roles de usuario. El administrador
 * tiene los mismos permisos de gestión de catálogo que un integrante
 * (crear, editar, eliminar productos), pero se crea de forma controlada
 * (seeder / consola), no por el formulario público de registro.
 */
return new class extends Migration
{
    public function up(): void
    {
        // MySQL/MariaDB: se modifica el enum directamente.
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN rol ENUM('cliente', 'integrante', 'administrador') NOT NULL DEFAULT 'cliente'");
        }
        // SQLite (usado en tests/desarrollo local): no hay enum real, la
        // columna ya es un string/varchar validado a nivel de aplicación,
        // así que no se necesita alterar el esquema.
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("UPDATE users SET rol = 'integrante' WHERE rol = 'administrador'");
            DB::statement("ALTER TABLE users MODIFY COLUMN rol ENUM('cliente', 'integrante') NOT NULL DEFAULT 'cliente'");
        }
    }
};
