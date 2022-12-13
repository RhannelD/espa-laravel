<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                $this->redirectToPanel($user);
            }
        }

        return $next($request);
    }

    public static function redirectToPanel($user)
    {
        if ($user->can('viewAnyDashboard')) {
            return redirect()->route('dashboard');
        } else if ($user->can('viewAnyStudent', \App\Models\User::class)) {
            return redirect()->route('student');
        } else if ($user->can('viewAny', \App\Models\Curriculum::class)) {
            return redirect()->route('curriculum');
        } else if ($user->can('viewAnyOfficer', \App\Models\User::class)) {
            return redirect()->route('officer');
        } else if ($user->can('viewAny', \App\Models\College::class)) {
            return redirect()->route('college');
        } else if ($user->can('viewAny', \App\Models\Program::class)) {
            return redirect()->route('program');
        } else if ($user->can('viewAny', \App\Models\Course::class)) {
            return redirect()->route('course');
        } else if ($user->can('viewAny', \Spatie\Permission\Models\Role::class)) {
            return redirect()->route('role');
        } else if ($user->can('viewAny', \Spatie\Permission\Models\Permission::class)) {
            return redirect()->route('permission');
        }
    }
}
