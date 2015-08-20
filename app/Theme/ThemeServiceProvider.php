<?php

namespace App\Theme;

use App\System\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{

    protected $namespace = 'theme';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/theme.php', 'theme');

        //why is this here? for the facade we aren't even using?
        //we don't have a binding for the actual theme injection? (do we inject Theme anywhere?)
        $this->app->singleton('App\Theme\ThemeManager', function ($app) {
            $theme = new ThemeManager($app['view'], new ThemeSelection(), new Theme(), $app['cache']->driver());

            $theme->boot($app['App\Account\AccountManager']);

            return $theme;
        });

        $this->app->bind('theme', function ($app) {

            return $app->make('App\Theme\ThemeManager');
        });

        $this->app->bind('App\Theme\Theme', function ($app) {
            return $app->make('theme')->current();
        });

        $files = scandir(config('theme.path'));

        $files = array_filter($files, function($file){
            return !in_array($file, ['.', '..', '.DS_Store', '.gitignore']);
        });

        foreach ($files as $theme) {
            $this->app->register(sprintf('Themes\\%s\\%sServiceProvider', $theme, $theme));
        }
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
    }

}