<?php

namespace App\Policies;

use App\Permission;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any permissions.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-permissions');
    }

    /**
     * Determine whether the user can view the permission.
     *
     * @param User $user
     * @param Permission $permission
     * @return mixed
     */
    public function view(User $user, Permission $permission)
    {
        return $user->role->permissions->contains('key','read-permissions') ||
        $user->id == $permission->created_id ||
        $user->id == $permission->updated_id;
    }

    /**
     * Determine whether the user can create permissions.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-permissions');
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param User $user
     * @param Permission $permission
     * @return mixed
     */
    public function update(User $user, Permission $permission)
    {
        return $user->role->permissions->contains('key','update-permissions') ||
        $user->id == $permission->created_id ||
        $user->id == $permission->updated_id;
    }

    /**
     * Determine whether the user can delete the permission.
     *
     * @param User $user
     * @param Permission $permission
     * @return mixed
     */
    public function delete(User $user, Permission $permission)
    {
        return $user->role->permissions->contains('key','delete-permissions') ||
        $user->id == $permission->created_id ||
        $user->id == $permission->updated_id;
    }
}
