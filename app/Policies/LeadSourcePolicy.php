<?php

namespace App\Policies;

use App\LeadSource;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadSourcePolicy
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
        return $user->role->permissions->contains('key','read-lead-sources');
    }

    /**
     * Determine whether the user can view the lead source.
     *
     * @param User $user
     * @param LeadSource $leadSource
     * @return mixed
     */
    public function view(User $user, LeadSource $leadSource)
    {
        return $user->role->permissions->contains('key','read-lead-sources') ||
        $user->id == $leadSource->created_id ||
        $user->id == $leadSource->updated_id;
    }

    /**
     * Determine whether the user can create lead sources.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-lead-sources');
    }

    /**
     * Determine whether the user can update the lead source.
     *
     * @param User $user
     * @param LeadSource $leadSource
     * @return mixed
     */
    public function update(User $user, LeadSource $leadSource)
    {
        return $user->role->permissions->contains('key','update-lead-sources') ||
        $user->id == $leadSource->created_id ||
        $user->id == $leadSource->updated_id;
    }

    /**
     * Determine whether the user can delete the lead source.
     *
     * @param User $user
     * @param LeadSource $leadSource
     * @return mixed
     */
    public function delete(User $user, LeadSource $leadSource)
    {
        return $user->role->permissions->contains('key','delete-lead-sources') ||
        $user->id == $leadSource->created_id ||
        $user->id == $leadSource->updated_id;
    }
}
