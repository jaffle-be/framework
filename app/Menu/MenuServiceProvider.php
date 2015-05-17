<?php namespace App\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //include our routes
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'menu');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'menu');
        $this->mergeConfigFrom(__DIR__ . '/config/menu.php', 'menu');

        //event listeners
        $this->listeners();

        $this->app['menu']->register('primary menu');
        $this->app['menu']->register('secondary menu');
    }

    public function register()
    {
        $this->app->bind('App\Menu\MenuRepositoryInterface', 'App\Menu\MenuRepository');

        $this->app->singleton('menu', 'App\Menu\MenuManager');
    }

    protected function listeners()
    {
    }
}