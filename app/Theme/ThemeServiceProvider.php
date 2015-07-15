<?php

namespace App\Theme;

use Jaffle\Tools\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider{

    protected $namespace = 'theme';
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

        $theme = config('theme.name');

        $theme = ucfirst(camel_case($theme));

        $this->app->register(sprintf('Themes\\%s\\%sServiceProvider', $theme, $theme));
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
    }

}