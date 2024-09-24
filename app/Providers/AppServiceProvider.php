<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define a gate for superadmin or adminCreate
        Gate::define('manage-data', function ($user) {
            return $user->isSuperadmin() || $user->isAdminCreate();
        });
    }
}
