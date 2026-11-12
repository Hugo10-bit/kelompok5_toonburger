<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        Paginator::defaultView('vendor.pagination.toonburger');

        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' 
            || str_contains(request()->getHttpHost(), 'trycloudflare.com') 
            || str_contains(request()->getHttpHost(), 'railway.app') 
            || config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
