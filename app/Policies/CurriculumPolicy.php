<?php

namespace App\Policies;

use App\Models\Curriculum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurriculumPolicy
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
        return $user->hasPermissionTo('Curriculum List')? true: null;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Curriculum $curriculum)
    {
        return $user->hasPermissionTo('Curriculum View')? true: null;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('Curriculum Create')? true: null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Curriculum $curriculum)
    {
        return $user->hasPermissionTo('Curriculum Update')? true: null;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Curriculum $curriculum)
    {
        return $user->hasPermissionTo('Curriculum Delete')? true: null;
    }

    /**
     * Determine whether the user can duplicate the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function duplicate(User $user, Curriculum $curriculum)
    {
        return $user->hasPermissionTo('Curriculum Duplicate')? true: null;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Curriculum $curriculum)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Curriculum $curriculum)
    {
        //
    }
}
