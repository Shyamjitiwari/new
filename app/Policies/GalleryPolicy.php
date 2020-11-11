<?php

namespace App\Policies;

use App\Gallery;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleryPolicy
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-galleries');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Gallery $gallery
     * @return mixed
     */
    public function view(User $user, Gallery $gallery)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','read-galleries') ||
            $user->id == $gallery->created_id ||
            $user->id == $gallery->updated_id;
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
            $user->role->permissions->contains('key','create-galleries');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Gallery $gallery
     * @return mixed
     */
    public function update(User $user, Gallery $gallery)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','update-galleries') ||
            $user->id == $gallery->created_id ||
            $user->id == $gallery->updated_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Gallery $gallery
     * @return mixed
     */
    public function delete(User $user, Gallery $gallery)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','delete-galleries') ||
            $user->id == $gallery->created_id ||
            $user->id == $gallery->updated_id;
    }
}
