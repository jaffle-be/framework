<?php

namespace App\Theme;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider{

    public function boot()
    {
        include(__DIR__ . '/helpers.php');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/theme.php', 'theme');

        $this->app->bind('App\Theme\Contracts\Theme', 'theme');
        $this->app->bind('theme', function($app){

            $theme = new Theme($app['config'], $app['view'], $app['events']);

            $theme->name(config('theme.name'));

            return $theme;
        });
    }

}