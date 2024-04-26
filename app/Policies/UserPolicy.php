<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     * 
     * @param User $user
     * @param string $ability
     * @return bool|null
     */
    public function before(User $user, string $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can update the user model.
     *
     * @param  User $user
     * @param  User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        if (
            $user->isStore() && !$model->isAdmin() && !$model->isStore() || # Store
            $user->id === $model->id # itself
        ) {
            return true;
        }

        return $this->deny();
    }
}
