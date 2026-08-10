<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modelo correspondiente a la clase "usuario" del diagrama de clases,
 * con sus subtipos representados por el campo `rol` (cliente|integrante)
 * en lugar de herencia física de tabla, por simplicidad relacional.
 */
class Usuario extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'usuarios';

    protected $fillable = [
        'email', 'password', 'rol', 'numero_de_contacto', 'nombre_del_integrante',
    ];

    protected $hidden = ['password'];

    public function esIntegrante(): bool
    {
        return $this->rol === 'integrante';
    }
}
