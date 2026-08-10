<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VentaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'producto_id' => $this->producto_id,
            'producto_nombre' => $this->whenLoaded('producto', fn () => $this->producto->nombre),
            'valor_de_la_venta' => $this->valor_de_la_venta,
            'cantidad_vendida' => $this->cantidad_vendida,
            'metodo_de_pago' => $this->metodo_de_pago,
            'fecha_hora' => $this->fecha_hora,
        ];
    }
}
