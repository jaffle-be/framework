<?php namespace App\Modules;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Modules\Contracts\ModuleRepositoryInterface', 'App\Modules\ModuleRepository');
    }
}