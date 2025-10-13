<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Observers\GenericObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        User::observe(GenericObserver::class);
        Role::observe(GenericObserver::class);
        Permission::observe(GenericObserver::class);
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
