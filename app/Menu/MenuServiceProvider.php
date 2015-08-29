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

        $this->app->extend('breadcrumbs', function()
        {
            $breadcrumbs = $this->app->make('App\Menu\Breadcrumbs');

            $breadcrumbs->setView(config('breadcrumbs.view'));

            return $breadcrumbs;
        });

        $this->app->bind('menu', 'App\Menu\MenuManager');
    }

    protected function listeners()
    {
        $this->app['menu']->register('primary menu');
        $this->app['menu']->register('secondary menu');
    }

    protected function observers()
    {

    }
}