<?php

namespace App\Policies;

use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-roles');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-roles') ||
        $user->id == $role->created_id ||
        $user->id == $role->updated_id;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','create-roles');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','update-roles') ||
        $user->id == $role->created_id ||
        $user->id == $role->updated_id;
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','delete-roles') ||
        $user->id == $role->created_id ||
        $user->id == $role->updated_id;
    }
}
