<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('producto_id')->constrained('productos');
            $table->string('nombre_de_producto');
            $table->decimal('valor_de_la_compra', 10, 2);
            $table->date('fecha_de_compra');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_compras');
    }
};
