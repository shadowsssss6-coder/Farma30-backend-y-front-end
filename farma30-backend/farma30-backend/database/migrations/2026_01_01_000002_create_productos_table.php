<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_de_ingreso');
            $table->date('fecha_vencimiento');
            $table->boolean('estado_de_disponibilidad')->default(true);
            $table->integer('cantidad')->default(0);
            $table->decimal('precio', 10, 2);
            $table->string('codigo_barras')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
