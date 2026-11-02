<?php

namespace App\Policies;

use App\Models\Institution;
use App\Models\User;

class InstitutionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator() || $user->hasRole('institution-admin');
    }

    public function view(User $user, Institution $institution): bool
    {
        return $user->isAdministrator() || $user->institution_id === $institution->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user, Institution $institution): bool
    {
        return $user->isAdministrator() || $user->institution_id === $institution->id;
    }

    public function delete(User $user, Institution $institution): bool
    {
        return $user->isAdministrator();
    }

    public function restore(User $user, Institution $institution): bool
    {
        return $user->isAdministrator();
    }

    public function forceDelete(User $user, Institution $institution): bool
    {
        return $user->hasRole('super-admin');
    }
}
