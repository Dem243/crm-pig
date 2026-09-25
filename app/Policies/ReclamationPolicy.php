<?php

namespace App\Policies;

use App\Models\Reclamation;
use App\Models\User;

class ReclamationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Reclamation $reclamation): bool
    {
        return $user->hasRole('admin', 'manager') || $reclamation->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return true; // toute personne authentifiee peut ouvrir une reclamation
    }

    public function update(User $user, Reclamation $reclamation): bool
    {
        return $user->hasRole('admin', 'manager') || $reclamation->assigned_to === $user->id;
    }

    public function delete(User $user, Reclamation $reclamation): bool
    {
        return $user->hasRole('admin');
    }
}
