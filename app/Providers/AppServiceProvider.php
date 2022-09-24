<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Voyager::addAction(\App\Actions\ActiveAction::class);
        Voyager::addAction(\App\Actions\ShowApplication::class);
        Voyager::addAction(\App\Actions\AddSignerAction::class);
    }
}
