<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any projects.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-projects');
    }

    /**
     * Determine whether the user can view the project.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        return $user->role->permissions->contains('key','read-projects') ||
        $user->id == $project->created_id ||
        $user->id == $project->updated_id;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-projects');
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $user->role->permissions->contains('key','update-projects') ||
        $user->id == $project->created_id ||
        $user->id == $project->updated_id;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $user->role->permissions->contains('key','delete-projects') ||
        $user->id == $project->created_id ||
        $user->id == $project->updated_id;
    }
}
