<?php

namespace App\Policies;

use App\LeadHistory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any lead histories.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-lead-histories');
    }

    /**
     * Determine whether the user can view the lead history.
     *
     * @param User $user
     * @param LeadHistory $leadHistory
     * @return mixed
     */
    public function view(User $user, LeadHistory $leadHistory)
    {
        return $user->role->permissions->contains('key','read-lead-histories') ||
        $user->id == $leadHistory->created_id ||
        $user->id == $leadHistory->updated_id;
    }

    /**
     * Determine whether the user can create lead histories.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-lead-histories');
    }

    /**
     * Determine whether the user can update the lead history.
     *
     * @param User $user
     * @param LeadHistory $leadHistory
     * @return mixed
     */
    public function update(User $user, LeadHistory $leadHistory)
    {
        return $user->role->permissions->contains('key','update-lead-histories') ||
        $user->id == $leadHistory->created_id ||
        $user->id == $leadHistory->updated_id;
    }

    /**
     * Determine whether the user can delete the lead history.
     *
     * @param User $user
     * @param LeadHistory $leadHistory
     * @return mixed
     */
    public function delete(User $user, LeadHistory $leadHistory)
    {
        return $user->role->permissions->contains('key','delete-lead-histories') ||
        $user->id == $leadHistory->created_id ||
        $user->id == $leadHistory->updated_id;
    }
}
