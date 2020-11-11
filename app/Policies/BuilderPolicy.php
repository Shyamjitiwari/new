<?php

namespace App\Policies;

use App\Builder;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuilderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any builders.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-builders');
    }

    /**
     * Determine whether the user can view the builder.
     *
     * @param User $user
     * @param Builder $builder
     * @return mixed
     */
    public function view(User $user, Builder $builder)
    {
        return $user->role->permissions->contains('key','read-builders') ||
        $user->id == $builder->created_id ||
        $user->id == $builder->updated_id;
    }

    /**
     * Determine whether the user can create builders.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-builders');
    }

    /**
     * Determine whether the user can update the builder.
     *
     * @param User $user
     * @param Builder $builder
     * @return mixed
     */
    public function update(User $user, Builder $builder)
    {
        return $user->role->permissions->contains('key','update-builders') ||
        $user->id == $builder->created_id ||
        $user->id == $builder->updated_id;
    }

    /**
     * @param User $user
     * @param Builder $builder
     * @return bool
     */
    public function transferOwner(User $user, Builder $builder)
    {
        return $user->role->permissions->contains('key','transfer-owner-builders') ||
        $user->id == $builder->created_id ||
        $user->id == $builder->updated_id ;
    }

    /**
     * Determine whether the user can delete the builder.
     *
     * @param User $user
     * @param Builder $builder
     * @return mixed
     */
    public function delete(User $user, Builder $builder)
    {
        return $user->role->permissions->contains('key','delete-builders') ||
        $user->id == $builder->created_id ||
        $user->id == $builder->updated_id;
    }
}
