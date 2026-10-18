<?php

namespace App\Policies;

use App\Models\User;

use App\Models\Venta;

class VentaPolicy
{
    public function create(User $user): bool
    {
        return $user->puedeGestionar();
    }

    public function viewResumen(User $user): bool
    {
        return $user->puedeGestionar();
    }

    public function ver(User $user, Venta $venta): bool
    {
    return $user->puedeGestionar();
    }
}
