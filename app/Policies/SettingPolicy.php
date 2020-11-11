<?php

namespace App\Policies;

use App\Setting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the setting.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','read-settings');
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
        return $user->isSuperAdmin() || $user->isAdmin() || $user->role->permissions->contains('key','update-settings');
    }
}
