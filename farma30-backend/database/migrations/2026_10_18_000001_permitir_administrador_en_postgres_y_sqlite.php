<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * La migración anterior solo ajustaba el enum de `rol` en MySQL. En PostgreSQL
 * (Render) y SQLite, Laravel crea la columna como varchar con una restricción
 * CHECK que sigue aceptando solo 'cliente' e 'integrante'. Aquí se corrige.
 */
return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            $restricciones = DB::select(
                "select conname from pg_constraint
                 where conrelid = 'users'::regclass and contype = 'c'
                 and pg_get_constraintdef(oid) ilike '%rol%'"
            );
            foreach ($restricciones as $r) {
                DB::statement('ALTER TABLE users DROP CONSTRAINT "'.$r->conname.'"');
            }
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_rol_check CHECK (rol IN ('cliente','integrante','administrador'))");
        } elseif ($driver === 'sqlite') {
            // Laravel 11+ reconstruye la tabla y elimina la restricción CHECK.
            Schema::table('users', function ($table) {
                $table->string('rol', 20)->default('cliente')->change();
            });
        }
        // MySQL/MariaDB ya queda resuelto por 2026_08_10_010000_add_administrador_rol_a_users.
    }

    public function down(): void
    {
        // Sin reversión: devolver la restricción impediría guardar administradores existentes.
    }
};
