<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** Nunca expone el campo password (protegido también por $hidden en el modelo). */
class UsuarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'rol' => $this->rol,
            'numero_de_contacto' => $this->numero_de_contacto,
            'nombre_del_integrante' => $this->nombre_del_integrante,
        ];
    }
}
