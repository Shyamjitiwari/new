<?php

namespace App\Policies;

use App\Location;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any locations.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-locations');
    }

    /**
     * Determine whether the user can view the location.
     *
     * @param User $user
     * @param Location $location
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        return $user->role->permissions->contains('key','read-locations') ||
        $user->id == $location->created_id ||
        $user->id == $location->updated_id;
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-locations');
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param User $user
     * @param Location $location
     * @return mixed
     */
    public function update(User $user, Location $location)
    {
        return $user->role->permissions->contains('key','update-locations') ||
        $user->id == $location->created_id ||
        $user->id == $location->updated_id;
    }

    /**
     * @param User $user
     * @param Location $location
     * @return bool
     */
    public function transferOwner(User $user, Location $location)
    {
        return $user->role->permissions->contains('key','transfer-owner-locations') ||
        $user->id == $location->created_id ||
        $user->id == $location->updated_id ;
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param User $user
     * @param Location $location
     * @return mixed
     */
    public function delete(User $user, Location $location)
    {
        return $user->role->permissions->contains('key','delete-locations') ||
        $user->id == $location->created_id ||
        $user->id == $location->updated_id;
    }
}
