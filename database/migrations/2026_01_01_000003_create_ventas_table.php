<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('rol', ['cliente', 'integrante'])->default('cliente');
            $table->string('numero_de_contacto')->nullable();
            $table->string('nombre_del_integrante')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'numero_de_contacto', 'nombre_del_integrante']);
        });
    }
};