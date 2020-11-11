<?php

namespace App\Policies;

use App\Setting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any settings.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the setting.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions->contains('key','read-settings');
    }

    /**
     * Determine whether the user can create settings.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the setting.
     *
     * @param User $user
     * @param Setting $setting
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions->contains('key','update-settings');
    }

    /**
     * Determine whether the user can delete the setting.
     *
     * @param User $user
     * @param Setting $setting
     * @return mixed
     */
    public function delete(User $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can restore the setting.
     *
     * @param User $user
     * @param Setting $setting
     * @return mixed
     */
    public function restore(User $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the setting.
     *
     * @param User $user
     * @param Setting $setting
     * @return mixed
     */
    public function forceDelete(User $user, Setting $setting)
    {
        //
    }
}
