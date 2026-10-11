<?php

namespace App\Providers;

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
        // El contenido de config/sitio.php queda disponible en todas las vistas como $sitio
        View::composer('*', fn ($view) => $view->with('sitio', config('sitio')));
    }
}
