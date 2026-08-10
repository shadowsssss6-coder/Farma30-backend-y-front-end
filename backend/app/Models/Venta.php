<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Corresponde a "Informacion_de_venta" del diagrama de clases. */
class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id', 'integrante_id', 'valor_de_la_venta', 'cantidad_vendida', 'metodo_de_pago',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function integrante()
    {
        return $this->belongsTo(User::class, 'integrante_id');
    }
}
