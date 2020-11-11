<?php

namespace App\Policies;

use App\Lead;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any leads.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-leads');
    }

    /**
     * Determine whether the user can view the lead.
     *
     * @param User $user
     * @param Lead $lead
     * @return mixed
     */
    public function view(User $user, Lead $lead)
    {
        return $user->role->permissions->contains('key','read-leads') ||
        $user->id == $lead->created_id ||
        $user->id == $lead->updated_id ||
        $user->assignedLeads()->searchMany('lead_id', $lead->id, 'assignedUsers')->count();
    }

    /**
     * Determine whether the user can create leads.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-leads');
    }

    /**
     * Determine whether the user can update the lead.
     *
     * @param User $user
     * @param Lead $lead
     * @return mixed
     */
    public function update(User $user, Lead $lead)
    {
        return $user->role->permissions->contains('key','update-leads') ||
        $user->id == $lead->created_id ||
        $user->id == $lead->updated_id ||
        $user->assignedLeads()->searchMany('lead_id', $lead->id, 'assignedUsers')->count();
    }

    /**
     * @param User $user
     * @param Lead $lead
     * @return bool
     */
    public function transferOwner(User $user, Lead $lead)
    {
        return $user->role->permissions->contains('key','transfer-owner-leads') ||
        $user->id == $lead->created_id ||
        $user->id == $lead->updated_id ||
        $user->assignedLeads()->searchMany('lead_id', $lead->id, 'assignedUsers')->count();
    }

    /**
     * Determine whether the user can delete the lead.
     *
     * @param User $user
     * @param Lead $lead
     * @return mixed
     */
    public function delete(User $user, Lead $lead)
    {
        return $user->role->permissions->contains('key','delete-leads') ||
        $user->id == $lead->created_id ||
        $user->id == $lead->updated_id ||
        $user->assignedLeads()->searchMany('lead_id', $lead->id, 'assignedUsers')->count();
    }
}
