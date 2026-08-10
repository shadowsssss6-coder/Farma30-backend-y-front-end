<?php

namespace App\Policies;

use App\Models\User;

/** Solo un integrante puede modificar el catálogo (RF04). */
class ProductoPolicy
{
    public function actualizar(User $user): bool
    {
        return $user->esIntegrante();
    }

    public function eliminar(User $user): bool
    {
        return $user->esIntegrante();
    }
}
