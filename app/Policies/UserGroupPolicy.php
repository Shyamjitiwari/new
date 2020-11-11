<?php

namespace App\Policies;

use App\User;
use App\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the userGroup can view any models.
     *
     * @param UserGroup $userGroup
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-user-groups');
    }

    /**
     * Determine whether the user can view the userGroup.
     *
     * @param User $user
     * @param UserGroup $userGroup
     * @return mixed
     */
    public function view(User $user, UserGroup $userGroup)
    {
        return $user->role->permissions->contains('key','read-user-groups') ||
        $user->id == $userGroup->created_id ||
        $user->id == $userGroup->updated_id;
    }

    /**
     * Determine whether the user can create user-groups.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-user-groups');
    }

    /**
     * Determine whether the user can update the userGroup.
     *
     * @param User $user
     * @param UserGroup $userGroup
     * @return mixed
     */
    public function update(User $user, UserGroup $userGroup)
    {
        return $user->role->permissions->contains('key','update-user-groups') ||
        $user->id == $userGroup->created_id ||
        $user->id == $userGroup->updated_id;
    }

   
    /**
     * Determine whether the user can delete the userGroup.
     *
     * @param User $user
     * @param UserGroup $userGroup
     * @return mixed
     */
    public function delete(User $user, UserGroup $userGroup)
    {
        return $user->role->permissions->contains('key','delete-user-groups') ||
        $user->id == $userGroup->created_id ||
        $user->id == $userGroup->updated_id;
    }
}
