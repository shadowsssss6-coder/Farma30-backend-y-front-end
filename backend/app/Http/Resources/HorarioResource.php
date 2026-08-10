<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HorarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'dia_semana' => $this->dia_semana,
            'hora_apertura' => $this->hora_apertura,
            'hora_cierre' => $this->hora_cierre,
        ];
    }
}
