<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFour();

        // Register model observers
        \App\Models\News::observe(\App\Observers\NewsObserver::class);
        \App\Models\Agenda::observe(\App\Observers\AgendaObserver::class);
    }
}
