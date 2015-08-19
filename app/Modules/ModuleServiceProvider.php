<?php namespace App\Modules;

use App\System\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    protected $namespace = 'modules';

    public function register()
    {
        $this->app->bind('App\Modules\Contracts\ModuleRepositoryInterface', 'App\Modules\ModuleRepository');
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
    }
}