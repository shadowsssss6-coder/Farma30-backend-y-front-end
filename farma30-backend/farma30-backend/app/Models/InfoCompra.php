<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoCompra extends Model
{
    protected $table = 'historial_compras';

    protected $fillable = ['usuario_id', 'producto_id', 'valor_de_la_compra', 'fecha_de_compra'];

    protected $casts = ['fecha_de_compra' => 'date'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
