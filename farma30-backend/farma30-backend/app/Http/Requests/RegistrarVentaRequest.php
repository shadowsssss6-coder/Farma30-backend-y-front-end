<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Valida RF06 (registrar venta). */
class RegistrarVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->puedeGestionar() ?? false;
    }

    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:productos,id',
            'cantidad_vendida' => 'required|integer|min:1',
            'valor_de_la_venta' => 'required|numeric|min:0.01',
            'metodo_de_pago' => ['required', Rule::in(['efectivo', 'electronico'])],
        ];
    }
}
