<?php namespace App\Menu;

use App\System\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{

    protected $namespace = 'menu';

    public function register()
    {
        $this->app->bind('App\Menu\MenuRepositoryInterface', 'App\Menu\CachedMenuRepository');

        $this->app->singleton('App\Menu\MenuManager', function ($app) {
            return new MenuManager($app['App\Menu\MenuRepositoryInterface'], $app['router']);
        });

        $this->app->bind('menu', 'App\Menu\MenuManager');
    }

    protected function listeners()
    {
        $this->app->booted(function(){
            $this->app['menu']->register('primary menu');
            $this->app['menu']->register('secondary menu');
        });

        $this->app['events']->listen('eloquent.saved:*', 'App\Menu\SavedMenuHookable');
    }

    protected function observers()
    {

    }
}