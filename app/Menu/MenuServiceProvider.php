<?php namespace App\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->app->bind('App\Menu\MenuRepositoryInterface', 'App\Menu\MenuRepository');

        $this->app->bind('menu', 'App\Menu\MenuManager');
    }
}