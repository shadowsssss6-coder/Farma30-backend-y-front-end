<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistorialCompraResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'producto_id' => $this->producto_id,
            'nombre_de_producto' => $this->nombre_de_producto,
            'valor_de_la_compra' => $this->valor_de_la_compra,
            'fecha_de_compra' => $this->fecha_de_compra,
        ];
    }
}
