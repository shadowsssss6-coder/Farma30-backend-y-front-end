<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Corresponde a "Carro de compras" del diagrama de clases. */
class CarritoItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'producto_id', 'cantidad_deseada', 'dia_de_adiccion'];

    protected function casts(): array
    {
        return ['dia_de_adiccion' => 'date'];
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
