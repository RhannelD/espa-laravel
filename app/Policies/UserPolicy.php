<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is a student.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function isStudent(User $user)
    {
            return $user->is_student;
    }

    /**
     * Determine whether the user can view any student models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAnyStudent(User $user)
    {
        return $user->hasPermissionTo('Student List') ? true : null;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewStudent(User $user, User $model)
    {
        return $user->hasPermissionTo('Student View') ? true : null;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createStudent(User $user)
    {
        return $user->hasPermissionTo('Student Create') ? true : null;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateStudent(User $user, User $model)
    {
        return $user->id == $model->id
        ? true
        : (
            $user->hasPermissionTo('Officer Update')
            ? true
            : null
        );
    }

    /**
     * Determine whether the user can update the password.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateStudentPassword(User $user, User $model)
    {
        return $user->id == $model->id
        ? true
        : (
            $user->hasPermissionTo('Officer Update')
            ? true
            : null
        );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteStudent(User $user, User $model)
    {
        return $user->hasPermissionTo('Student Delete') ? true : null;
    }

    /**
     * Determine whether the user can view the student's curriculum.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewStudentCurriculum(User $user, User $model)
    {
        return (!$model->isStudent) ? false : ($user->hasPermissionTo('Student Curriculum View') ? true : null);
    }

    /**
     * Determine whether the user can update the student's curriculum.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateStudentCurriculum(User $user, User $model)
    {
        return (!$model->isStudent) ? false : ($user->hasPermissionTo('Student Curriculum Update') ? true : null);
    }

    /**
     * Determine whether the user can update the student's grades.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateStudentGrade(User $user, User $model)
    {
        return (!$model->isStudent) ? false : ($user->hasPermissionTo('Student Grade Update') ? true : null);
    }

    /**
     * Determine whether the user can delete the student's grades.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteStudentGrade(User $user, User $model)
    {
        return (!$model->isStudent) ? false : ($user->hasPermissionTo('Student Grade Delete') ? true : null);
    }

    // ----------------------------------------------------------------------------------

    /**
     * Determine whether the user can view any officer models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewOfficer(User $user)
    {
        return $user->hasPermissionTo('Officer View') ? true : null;
    }

    /**
     * Determine whether the user can view any officer models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAnyOfficer(User $user)
    {
        return $user->hasPermissionTo('Officer List') ? true : null;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createOfficer(User $user)
    {
        return $user->hasPermissionTo('Officer Create') ? true : null;
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
     * Determine whether the user can update the role and access of the user.
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
     * Determine whether the user can update the password.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateOfficerRoleAccess(User $user, User $model)
    {
        return ($user->id == $model->id || $user->is_student || $model->hasRole('Super Admin'))
        ? false
        : (
            $user->hasPermissionTo('Officer Role Permission Update')
            ? true
            : null
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
        return ($model->hasRole('Super Admin')) ? false : ($user->hasPermissionTo('Officer Delete') ? true : null);
    }
}
