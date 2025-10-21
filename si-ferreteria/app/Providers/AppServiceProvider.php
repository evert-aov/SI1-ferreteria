<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\GenericObserver;
use App\Observers\ProductObserve;
use App\Observers\PurchaseObserver;
use App\Observers\UserObserver;
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
        User::observe(UserObserver::class);
        Role::observe(GenericObserver::class);
        Permission::observe(GenericObserver::class);
        Product::observe(ProductObserve::class);
        Category::observe(CategoryObserver::class);
        Entry::observe(PurchaseObserver::class);
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
