<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Valida RF04 (alta de producto nuevo en el catálogo). Solo integrante/administrador. */
class CrearProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->puedeGestionar() ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'estado_de_disponibilidad' => 'sometimes|boolean',
            'fecha_de_ingreso' => 'sometimes|date',
            'fecha_vencimiento' => 'required|date',
            'codigo_barras' => 'nullable|string|max:64|unique:productos,codigo_barras',
        ];
    }
}
