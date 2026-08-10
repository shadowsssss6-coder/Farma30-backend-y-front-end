<?php

namespace App\Policies;

use App\Models\Usuario;

class VentaPolicy
{
    public function create(Usuario $usuario): bool
    {
        return $usuario->esIntegrante();
    }

    public function viewResumen(Usuario $usuario): bool
    {
        return $usuario->esIntegrante();
    }
}
