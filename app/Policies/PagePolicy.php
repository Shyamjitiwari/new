<?php

namespace App\Policies;

use App\Page;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-pages');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Page $page
     * @return mixed
     */
    public function view(User $user, Page $page)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','read-pages') ||
            $user->id == $page->created_id ||
            $user->id == $page->updated_id;
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
            $user->role->permissions->contains('key','create-pages');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Page $page
     * @return mixed
     */
    public function update(User $user, Page $page)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','update-pages') ||
            $user->id == $page->created_id ||
            $user->id == $page->updated_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Page $page
     * @return mixed
     */
    public function delete(User $user, Page $page)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','delete-pages') ||
            $user->id == $page->created_id ||
            $user->id == $page->updated_id;
    }
}
