<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Corresponde a la clase "usuario" del diagrama de clases, con sus
 * dos roles: cliente e integrante, distinguidos por el campo `rol`.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email', 'password', 'rol', 'numero_de_contacto', 'nombre_del_integrante',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function esIntegrante(): bool
    {
        return $this->rol === 'integrante';
    }

    public function esCliente(): bool
    {
        return $this->rol === 'cliente';
    }
}
