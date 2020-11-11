<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */

    public function viewAny(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-users') ||
        $user->id == $model->created_id ||
        $user->id == $model->updated_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','create-users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','update-users') ||
        $user->id == $model->created_id ||
        $user->id == $model->updated_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','delete-users') ||
        $user->id == $model->created_id ||
        $user->id == $model->updated_id;
    }
}
