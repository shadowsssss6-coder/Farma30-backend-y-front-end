<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('producto_id')->constrained('productos');
            $table->integer('cantidad_deseada');
            $table->date('dia_de_adiccion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};
