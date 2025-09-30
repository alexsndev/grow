<?php

namespace App\Policies;

use App\Models\Demand;
use App\Models\User;

class DemandPolicy
{
    public function update(User $user, Demand $demand)
    {
        // Admin pode tudo; autor pode editar título/descrição (controlado no controller)
        return $user->email === 'admin@admin.com' || $demand->user_id === $user->id;
    }

    public function delete(User $user, Demand $demand)
    {
        // Apenas admin remove
        return $user->email === 'admin@admin.com';
    }
}
