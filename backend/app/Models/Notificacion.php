<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'mensaje', 'porcentaje_descuento', 'leida'];

    protected function casts(): array
    {
        return ['leida' => 'boolean'];
    }
}
