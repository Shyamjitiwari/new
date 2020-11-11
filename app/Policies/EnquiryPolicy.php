<?php

namespace App\Policies;

use App\Enquiry;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnquiryPolicy
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-enquiries');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Enquiry $enquiry
     * @return mixed
     */
    public function view(User $user, Enquiry $enquiry)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','read-enquiries') ||
            $user->id == $enquiry->created_id ||
            $user->id == $enquiry->updated_id;
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
            $user->role->permissions->contains('key','create-enquiries');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Enquiry $enquiry
     * @return mixed
     */
    public function update(User $user, Enquiry $enquiry)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','update-enquiries') ||
            $user->id == $enquiry->created_id ||
            $user->id == $enquiry->updated_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Enquiry $enquiry
     * @return mixed
     */
    public function delete(User $user, Enquiry $enquiry)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','delete-enquiries') ||
            $user->id == $enquiry->created_id ||
            $user->id == $enquiry->updated_id;
    }
}
