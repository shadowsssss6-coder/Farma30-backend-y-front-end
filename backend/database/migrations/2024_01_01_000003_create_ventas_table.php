<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->decimal('valor_de_la_venta', 10, 2);
            $table->integer('cantidad_vendida');
            $table->enum('metodo_de_pago', ['efectivo', 'electronico']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
