<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarritoItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'producto_id' => $this->producto_id,
            'producto_nombre' => $this->whenLoaded('producto', fn () => $this->producto->nombre),
            'cantidad_deseada' => $this->cantidad_deseada,
            'dia_de_adiccion' => $this->dia_de_adiccion,
        ];
    }
}
