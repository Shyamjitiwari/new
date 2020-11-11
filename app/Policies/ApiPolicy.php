<?php

namespace App\Policies;

use App\Api;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any apis.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-apis');
    }

    /**
     * Determine whether the user can view the lead source.
     *
     * @param User $user
     * @param Api $api
     * @return mixed
     */
    public function view(User $user, Api $api)
    {
        return $user->role->permissions->contains('key','read-apis') ||
        $user->id == $api->created_id ||
        $user->id == $api->updated_id;
    }

    /**
     * Determine whether the user can create apis.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-apis');
    }

    /**
     * Determine whether the user can update the lead source.
     *
     * @param User $user
     * @param Api $api
     * @return mixed
     */
    public function update(User $user, Api $api)
    {
        return $user->role->permissions->contains('key','update-apis') ||
        $user->id == $api->created_id ||
        $user->id == $api->updated_id;
    }

    /**
     * Determine whether the user can delete the lead source.
     *
     * @param User $user
     * @param Api $api
     * @return mixed
     */
    public function delete(User $user, Api $api)
    {
        return $user->role->permissions->contains('key','delete-apis') ||
        $user->id == $api->created_id ||
        $user->id == $api->updated_id;
    }
}
