<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/** Corresponde a "Info de un Producto" del diagrama de clases. */
class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'fecha_de_ingreso', 'fecha_vencimiento',
        'estado_de_disponibilidad', 'cantidad', 'precio', 'codigo_barras',
    ];

    protected function casts(): array
    {
        return [
            'fecha_de_ingreso' => 'date',
            'fecha_vencimiento' => 'date',
            'estado_de_disponibilidad' => 'boolean',
        ];
    }

    public function estaProximoAVencer(int $diasUmbral = 30): bool
    {
        return $this->fecha_vencimiento->lte(Carbon::now()->addDays($diasUmbral));
    }

    public function estaVencido(): bool
    {
        return $this->fecha_vencimiento->isPast();
    }
}
