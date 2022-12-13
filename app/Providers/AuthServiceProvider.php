<?php

namespace App\Providers;

use App\Policies\DashboardPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \Spatie\Permission\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \Spatie\Permission\Models\Role::class => \App\Policies\RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('viewAnyDashboard', [DashboardPolicy::class, 'viewAnyDashboard']);

        Gate::after(function ($user, $ability) {
            return $user->hasRole('Super Admin');
        });
    }
}
