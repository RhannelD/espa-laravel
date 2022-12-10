<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        return $user->id == $model->id? true: null;
    }

    /**
     * Determine whether the user can update the password.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updatePassword(User $user, User $model)
    {
        return $user->id == $model->id? true: null;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return !$model->isSuserAdmin;
    }

    /**
     * Determine whether the user can view any officer models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewOfficer(User $user)
    {
        return $user->hasPermissionTo('Officer View')? true: null;
    }

    /**
     * Determine whether the user can view any officer models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAnyOfficer(User $user)
    {
        return $user->hasPermissionTo('Officer List')? true: null;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createOfficer(User $user)
    {
        return $user->hasPermissionTo('Officer Create')? true: null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateOfficer(User $user, User $model)
    {
        return $user->id == $model->id
            ? true
            : (
                $model->hasRole('Super Admin')
                    ? false
                    : (
                        $user->hasPermissionTo('Officer Update')
                            ? true
                            : null
                    )
            );
    }

    /**
     * Determine whether the user can update the password.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateOfficerPassword(User $user, User $model)
    {
        return $user->id == $model->id
            ? true
            : (
                $model->hasRole('Super Admin')
                    ? false
                    : (
                        $user->hasPermissionTo('Officer Password Update')
                            ? true
                            : null
                    )
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteOfficer(User $user, User $model)
    {
        return ($model->hasRole('Super Admin'))? false: ($user->hasPermissionTo('Officer Delete')? true: null);
    }
}
