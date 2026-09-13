<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad,
            'estado_de_disponibilidad' => $this->estado_de_disponibilidad,
            'fecha_vencimiento' => $this->fecha_vencimiento->toDateString(),
            'codigo_barras' => $this->codigo_barras,
        ];
    }
}
