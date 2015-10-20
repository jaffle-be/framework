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
            //we might want to provide 5 menus instead of allow each theme to define it's own menus.
            //a theme can simply decide to hook into them or not.
            //maybe you could also register a 'dynamic' menu, to load in the sidebar
            //the items it shows could for example be our documentation?
            $this->app['menu']->register('primary menu');
            //$this->app['menu']->register('secondary menu');
            $this->app['menu']->register('footer menu');
            //$this->app['menu']->register('shopping menu');
            //$this->app['menu']->register('shopping secondary menu');

        });

        $this->app['events']->listen('eloquent.saved:*', 'App\Menu\SavedMenuHookable');
    }

    protected function observers()
    {

    }
}