<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NovaPolicy
{
    use HandlesAuthorization;

    public function viewNova(User $user)
    {
        // Customize this logic to determine who can view the Nova dashboard.
        // For example, you can allow all authenticated users:
        return true;

        // Or, you can restrict access to only specific users or roles:
        // return $user->isAdmin() || $user->hasRole('manager');
    }
}
