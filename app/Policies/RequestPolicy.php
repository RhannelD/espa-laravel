<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
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
        return $user->hasPermissionTo('Request List') ? true : ($user->is_student ? true : null);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Request $request)
    {
        return $user->id == $request->user_id ? true : ($user->hasPermissionTo('Request View') ? true : null);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->is_student;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Request $request)
    {
        //
    }

    /**
     * Determine whether the user can response the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function response(User $user, Request $request)
    {
        return $user->hasPermissionTo('Request Response') ? true : null;
    }

    /**
     * Determine whether the user can comment on the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function comment(User $user, Request $request)
    {
        return $user->id == $request->user_id ? true : ($user->hasPermissionTo('Request Response') ? true : null);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Request $request)
    {
        return $user->is_student;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Request $request)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Request $request)
    {
        //
    }
}
