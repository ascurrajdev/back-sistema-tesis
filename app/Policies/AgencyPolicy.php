<?php

namespace App\Policies;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
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
        return $user->tokenCan('agencies-index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Agency $agency)
    {
        return $user->tokenCan('agencies-view');
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Agency $agency)
    {
        return $user->tokenCan('agencies-delete');
    }

}
