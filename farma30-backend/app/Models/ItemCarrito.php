<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCarrito extends Model
{
    protected $table = 'carrito_items';

    protected $fillable = ['usuario_id', 'producto_id', 'cantidad_deseada'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
