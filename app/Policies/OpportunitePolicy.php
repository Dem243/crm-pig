<?php

namespace App\Policies;

use App\Models\Opportunite;
use App\Models\User;

class OpportunitePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Opportunite $opportunite): bool
    {
        return $user->hasRole('admin', 'manager') || $opportunite->commercial_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin', 'manager', 'commercial');
    }

    public function update(User $user, Opportunite $opportunite): bool
    {
        return $user->hasRole('admin', 'manager') || $opportunite->commercial_id === $user->id;
    }

    public function delete(User $user, Opportunite $opportunite): bool
    {
        return $user->hasRole('admin', 'manager');
    }
}
