<?php

namespace App\Providers;

use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use App\Models\Purchase\Entry;
use App\Models\User_security\Permission;
use App\Models\User_security\Role;
use \App\Models\User_security\User;
use App\Observers\CategoryObserver;
use App\Observers\GenericObserver;
use App\Observers\ProductObserve;
use App\Observers\PurchaseObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\URL;
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
