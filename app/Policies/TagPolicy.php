<?php

namespace App\Policies;

use App\Tag;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TagPolicy
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-tags')
            ? Response::allow()
            : Response::deny('You are not authorized to view these records.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Tag $tag
     * @return mixed
     */
    public function view(User $user, Tag $tag)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-tags') ||
            $user->id == $tag->created_id ||
            $user->id == $tag->updated_id
            ? Response::allow()
            : Response::deny('You are not authorized to view this record.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','create-tags')
            ? Response::allow()
            : Response::deny('You are not authorized to create new record.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Tag $tag
     * @return mixed
     */
    public function update(User $user, Tag $tag)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','update-tags') ||
            $user->id == $tag->created_id ||
            $user->id == $tag->updated_id
            ? Response::allow()
            : Response::deny('You are not authorized to update this record.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Tag $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','delete-tags') ||
            $user->id == $tag->created_id ||
            $user->id == $tag->updated_id
                ? Response::allow()
                : Response::deny('You are not authorized to delete this record.');
    }

}
