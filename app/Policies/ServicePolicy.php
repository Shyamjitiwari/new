<?php

namespace App\Policies;

use App\Service;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-services');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function view(User $user, Service $service)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','read-services') ||
            $user->id == $service->created_id ||
            $user->id == $service->updated_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','create-services');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','update-services') ||
            $user->id == $service->created_id ||
            $user->id == $service->updated_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','delete-services') ||
            $user->id == $service->created_id ||
            $user->id == $service->updated_id;
    }
}
