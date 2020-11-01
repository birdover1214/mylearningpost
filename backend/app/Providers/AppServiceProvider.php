<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\SkillSortService');
        $this->app->bind('App\Services\GetDataService');
        $this->app->bind('App\Services\FavoriteService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(request()->isSecure()) {
            \URL::forceScheme('https');
        }
    }
}
