<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Corresponde a "info_de_compras" del diagrama de clases. */
class HistorialCompra extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'producto_id', 'nombre_de_producto', 'valor_de_la_compra', 'fecha_de_compra'];

    protected function casts(): array
    {
        return ['fecha_de_compra' => 'date'];
    }
}
