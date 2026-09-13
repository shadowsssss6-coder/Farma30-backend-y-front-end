<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificacionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'mensaje' => $this->mensaje,
            'porcentaje_descuento' => $this->porcentaje_descuento,
            'leida' => $this->leida,
            'fecha' => $this->created_at,
        ];
    }
}
