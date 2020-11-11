<?php

namespace App\Policies;

use App\Slider;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-sliders');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Slider $slider
     * @return mixed
     */
    public function view(User $user, Slider $slider)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','read-sliders') ||
            $user->id == $slider->created_id ||
            $user->id == $slider->updated_id;
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
            $user->role->permissions->contains('key','create-sliders');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Slider $slider
     * @return mixed
     */
    public function update(User $user, Slider $slider)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','update-sliders') ||
            $user->id == $slider->created_id ||
            $user->id == $slider->updated_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Slider $slider
     * @return mixed
     */
    public function delete(User $user, Slider $slider)
    {
        return $user->isSuperAdmin() || $user->isAdmin() ||
            $user->role->permissions->contains('key','delete-sliders') ||
            $user->id == $slider->created_id ||
            $user->id == $slider->updated_id;
    }
}
