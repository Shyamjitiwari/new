<?php

namespace App\Policies;

use App\LeadStatus;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any lead policies.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-lead-statuses');
    }

    /**
     * Determine whether the user can view the lead policy.
     *
     * @param User $user
     * @param LeadStatus $LeadStatus
     * @return mixed
     */
    public function view(User $user, LeadStatus $LeadStatus)
    {
        return $user->role->permissions->contains('key','read-lead-statuses') ||
        $user->id == $LeadStatus->created_id ||
        $user->id == $LeadStatus->updated_id;
    }

    /**
     * Determine whether the user can create lead policies.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-lead-statuses');
    }

    /**
     * Determine whether the user can update the lead policy.
     *
     * @param User $user
     * @param LeadStatus $LeadStatus
     * @return mixed
     */
    public function update(User $user, LeadStatus $LeadStatus)
    {
        return $user->role->permissions->contains('key','update-lead-statuses') ||
        $user->id == $LeadStatus->created_id ||
        $user->id == $LeadStatus->updated_id;
    }

    /**
     * Determine whether the user can delete the lead policy.
     *
     * @param User $user
     * @param LeadStatus $LeadStatus
     * @return mixed
     */
    public function delete(User $user, LeadStatus $LeadStatus)
    {
        return $user->role->permissions->contains('key','delete-lead-statuses') ||
        $user->id == $LeadStatus->created_id ||
        $user->id == $LeadStatus->updated_id;
    }
}
