<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        Gate::define('admin', function (User $user) {
            return $user->hasPermission('admin');
        });

        Gate::define('default', function (User $user) {
            return $user->hasPermission('default');
        });
    }
}
