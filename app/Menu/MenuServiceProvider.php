<?php namespace App\Menu;

use Jaffle\Tools\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    protected $namespace = 'menu';

    public function register()
    {
        $this->app->bind('App\Menu\MenuRepositoryInterface', 'App\Menu\MenuRepository');

        $this->app->singleton('menu', 'App\Menu\MenuManager');
    }

    protected function listeners()
    {
        $this->app['menu']->register('primary menu');
        $this->app['menu']->register('secondary menu');
    }

    protected function observers()
    {
        MenuItem::observe($this->app->make('App\Menu\MenuItemObserver'));
    }
}