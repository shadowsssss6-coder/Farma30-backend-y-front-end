<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'rol' => ['required', Rule::in(['cliente', 'integrante'])],
            'numero_de_contacto' => 'required_if:rol,cliente|nullable|string',
            'nombre_del_integrante' => 'required_if:rol,integrante|nullable|string',
        ];
    }
}
