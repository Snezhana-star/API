<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('Admin', function ($user) {
            return $user->role_id === 2;
        });
        Gate::define('show-user', function ($user, $id) {
            return $user->role_id === 2 or $user->id == $id;
        });
        Gate::define('Editor', function ($user) {
            return $user->role_id === 3;
        });
        Gate::define('User', function ($user, $id) {
            return $user->id == $id;
        });
    }
}
