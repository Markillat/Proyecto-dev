<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->role === UserRole::ADMIN->value) {
            return true;
        }
    }

    public function viewUsers(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }


    /**
     * Determine whether the user can create models.
     */
    public function createUser(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function showUser(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }
}
