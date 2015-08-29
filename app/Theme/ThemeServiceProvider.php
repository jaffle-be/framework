<?php

namespace App\Theme;

use App\System\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{

    protected $namespace = 'theme';

    public function boot()
    {
        parent::boot();

        $this->app->booted(function($app){
            $this->app->make('theme')->boot();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/theme.php', 'theme');

        $this->app->bind('theme', 'App\Theme\ThemeManager');

        $this->app->singleton('App\Theme\ThemeManager', function ($app) {
            return new ThemeManager($app['view'], $app['App\Theme\ThemeRepositoryInterface']);
        });

        $this->app->bind('App\Theme\Theme', function ($app) {
            return $app->make('theme')->current();
        });

        $this->registerRepositories();

        $this->registerThemeServiceProviders();
    }

    protected function observers()
    {
    }

    protected function listeners()
    {

    }

    protected function registerRepositories()
    {
        //you need this defined, do not resolve from container,
        // as the Theme will fail and result in endless nesting.
        $this->app->bind('App\Theme\ThemeRepository', function()
        {
            return new ThemeRepository(new ThemeSelection(), new Theme(), app('App\Account\AccountManager'));
        });

        $this->app->bind('App\Theme\ThemeRepositoryInterface', 'App\Theme\CachedThemeRepository');
    }

    protected function registerThemeServiceProviders()
    {
        /**
         * @todo improve registering theme service providers
         *
         *       This should only happen once at the theme selection page.
         *       else, we should use the account one, or fallback to our default theme.
         */

        $files = scandir(config('theme.path'));

        $files = array_filter($files, function ($file) {
            return !in_array($file, ['.', '..', '.DS_Store', '.gitignore']);
        });

        foreach ($files as $theme) {
            $this->app->register(sprintf('Themes\\%s\\%sServiceProvider', $theme, $theme));
        }
    }

}