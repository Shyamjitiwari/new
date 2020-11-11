<?php

namespace App\Policies;

use App\ProjectUnit;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectUnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any lead sources.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
       
        return $user->role->permissions->contains('key','read-project-units');
    }

    /**
     * Determine whether the user can view the lead source.
     *
     * @param User $user
     * @param ProjectUnit $projectUnit
     * @return mixed
     */
    public function view(User $user, ProjectUnit $projectUnit)
    {
        return $user->role->permissions->contains('key','read-project-units') ||
        $user->id == $projectUnit->created_id ||
        $user->id == $projectUnit->updated_id;
    }

    /**
     * Determine whether the user can create lead sources.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-project-units');
    }

    /**
     * Determine whether the user can update the lead source.
     *
     * @param User $user
     * @param ProjectUnit $projectUnit
     * @return mixed
     */
    public function update(User $user, ProjectUnit $projectUnit)
    {
        return $user->role->permissions->contains('key','update-project-units') ||
        $user->id == $projectUnit->created_id ||
        $user->id == $projectUnit->updated_id;
    }

    /**
     * Determine whether the user can delete the lead source.
     *
     * @param User $user
     * @param ProjectUnit $projectUnit
     * @return mixed
     */
    public function delete(User $user, ProjectUnit $projectUnit)
    {
        return $user->role->permissions->contains('key','delete-project-units') ||
        $user->id == $projectUnit->created_id ||
        $user->id == $projectUnit->updated_id;
    }
}
