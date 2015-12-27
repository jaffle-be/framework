<?php

namespace Modules\Theme\Providers;

use Modules\Theme\Theme;
use Modules\Theme\ThemeManager;
use Modules\Theme\ThemeRepository;
use Modules\Theme\ThemeSelection;
use Modules\System\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    protected $namespace = 'theme';

    public function boot()
    {
        parent::boot();

        $this->app->booted(function ($app) {
            $this->app->make('theme')->boot();
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('theme', 'Modules\Theme\ThemeManager');

        $this->app->singleton('Modules\Theme\ThemeManager', function ($app) {
            return new ThemeManager($app['view'], $app['Modules\Theme\ThemeRepositoryInterface']);
        });

        $this->app->bind('Modules\Theme\Theme', function ($app) {
            return $app->make('theme')->current();
        });

        $this->registerRepositories();

        $this->registerThemeServiceProviders();
    }

    protected function listeners()
    {
    }

    protected function registerRepositories()
    {
        //you need this defined, do not resolve from container,
        // as the Theme will fail and result in endless nesting.
        $this->app->bind('Modules\Theme\ThemeRepository', function () {
            return new ThemeRepository(new ThemeSelection(), new Theme(), app('Modules\Account\AccountManager'));
        });

        $this->app->bind('Modules\Theme\ThemeRepositoryInterface', 'Modules\Theme\CachedThemeRepository');
    }

    protected function registerThemeServiceProviders()
    {
        /*
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
            $this->app->register(sprintf('Themes\\%s\\Providers\\%sServiceProvider', $theme, $theme));
        }
    }
}
