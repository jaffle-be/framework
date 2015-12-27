<?php

namespace Modules\Menu\Providers;

use Modules\Menu\MenuManager;
use Modules\System\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    protected $namespace = 'menu';

    public function register()
    {
        $this->app->bind('Modules\Menu\MenuRepositoryInterface', 'Modules\Menu\CachedMenuRepository');

        $this->app->singleton('Modules\Menu\MenuManager', function ($app) {
            return new MenuManager($app['Modules\Menu\MenuRepositoryInterface'], $app['router']);
        });

        $this->app->bind('menu', 'Modules\Menu\MenuManager');
    }

    protected function listeners()
    {
        $this->app->booted(function () {
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

        $this->app['events']->listen('eloquent.saved:*', 'Modules\Menu\SavedMenuHookable');
    }
}
