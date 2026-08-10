<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Valida RF04 (edición de producto), regla de negocio: cantidad no negativa. */
class ActualizarProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->esIntegrante() ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric|min:0',
            'cantidad' => 'sometimes|required|integer|min:0',
            'estado_de_disponibilidad' => 'sometimes|boolean',
            'fecha_vencimiento' => 'sometimes|date',
        ];
    }
}
