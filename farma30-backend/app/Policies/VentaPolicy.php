<?php

namespace App\Policies;

use App\Models\User;

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
}
