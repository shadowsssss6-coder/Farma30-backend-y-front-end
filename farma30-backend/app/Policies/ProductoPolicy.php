<?php

namespace App\Policies;

use App\Models\User;

/** Integrante y administrador pueden gestionar el catálogo (RF04); cliente no. */
class ProductoPolicy
{
    public function crear(User $user): bool
    {
        return $user->puedeGestionar();
    }

    public function actualizar(User $user): bool
    {
        return $user->puedeGestionar();
    }

    public function eliminar(User $user): bool
    {
        return $user->puedeGestionar();
    }
}
