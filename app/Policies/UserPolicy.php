<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $loginUser
     * @param  \App\User  $targetUser
     * @return mixed
     */
    public function update(User $loginUser, User $targetUser): bool
    {
        return $loginUser->id === $targetUser->id;
    }
}