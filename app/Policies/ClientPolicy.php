<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // tous les roles voient la liste (filtree dans le controleur)
    }

    public function view(User $user, Client $client): bool
    {
        return $user->hasRole('admin', 'manager') || $client->commercial_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin', 'manager', 'commercial');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->hasRole('admin', 'manager') || $client->commercial_id === $user->id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->hasRole('admin', 'manager');
    }
}
