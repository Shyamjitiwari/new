<?php

namespace App\Policies;

use App\Testimonial;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestimonialPolicy
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-testimonials');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Testimonial $testimonial
     * @return mixed
     */
    public function view(User $user, Testimonial $testimonial)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','read-testimonials') ||
            $user->id == $testimonial->created_id ||
            $user->id == $testimonial->updated_id;
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
            $user->role->permissions->contains('key','create-testimonials');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Testimonial $testimonial
     * @return mixed
     */
    public function update(User $user, Testimonial $testimonial)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','update-testimonials') ||
            $user->id == $testimonial->created_id ||
            $user->id == $testimonial->updated_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Testimonial $testimonial
     * @return mixed
     */
    public function delete(User $user, Testimonial $testimonial)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','delete-testimonials') ||
            $user->id == $testimonial->created_id ||
            $user->id == $testimonial->updated_id;
    }
}
