<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;

class CartComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share cart count with all views
        view()->composer('*', function ($view) {
            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = Cart::where('user_id', auth()->id())->whereHas('book')->count();
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
