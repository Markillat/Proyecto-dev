<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkstationPolicy
{
    use HandlesAuthorization;
    public function createJob(User $authenticatedUser): bool
    {
        return $authenticatedUser->role === UserRole::ADMIN->value;
    }
}
