<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgregarCarritoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->esCliente() ?? false;
    }

    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:productos,id',
            'cantidad_deseada' => 'required|integer|min:1',
        ];
    }
}
