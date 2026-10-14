<?php

namespace App\Providers;

use App\Services\SitioBuilder;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            if (! str_starts_with($view->name(), 'admin.')) {
                $view->with('sitio', app(SitioBuilder::class)->build());
            }
        });
    }
}
