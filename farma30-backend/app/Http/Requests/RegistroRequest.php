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
        // El registro público SOLO crea clientes. Los integrantes los crea un administrador.
        'rol' => ['sometimes', Rule::in(['cliente'])],
        'numero_de_contacto' => 'required|string|max:30',
    ];
}
}
