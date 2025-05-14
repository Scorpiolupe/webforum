<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Http\ViewComposers\CategoryComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Türkçe dil desteği
        Carbon::setLocale('tr');
        
        // Share categories with all views
        View::composer('*', CategoryComposer::class);
    }
}
