<?php

namespace App\Policies;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoleUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->tokenCan('roles-users-index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RoleUser  $roleUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, RoleUser $roleUser)
    {
        return $user->tokenCan('roles-users-view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->tokenCan('roles-users-store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RoleUser  $roleUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, RoleUser $roleUser)
    {
        return $user->tokenCan('roles-users-update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RoleUser  $roleUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, RoleUser $roleUser)
    {
        return $user->tokenCan('roles-users-delete');
    }

}
