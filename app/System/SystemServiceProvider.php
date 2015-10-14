<?php

namespace App\System;

use App\System\Cache\CacheManager;
use App\System\Queue\RedisConnector;
use Blade;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;

class SystemServiceProvider extends ServiceProvider
{

    protected $namespace = 'system';

    public function boot()
    {
        parent::boot();

        $this->extendCache();

        $this->extendQueues();

        $this->validators();

        $this->viewGlobals();

        $this->bladeCopyright();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/system.php', 'system'
        );

        $this->app->singleton('seo', function($app)
        {
            return new Seo\SeoManager($app['config']);
        });

        $this->app->bind('App\System\Seo\SeoManager', 'seo');

        $this->app->booted(function ($app) {
            $app['newrelic']->setAppName(env('APP_NAME'));
        });

        $this->app->booted(function($app)
        {
            $app['markdown.environment']->addExtension(new AttributesExtension());
        });
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
        $this->automateUriCleanup();
    }

    protected function validators()
    {
        $this->app->make('validator')->extend('vat', 'App\System\Validators\Vat@validate');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application
     */
    protected function viewGlobals()
    {
        /** @var Factory $view */
        $this->app['view']->composer('*', function (View $view) {

            if (!isset($view['account'])) {
                $accounts = app('App\Account\AccountManager');
                $view->with('account', $accounts->account());
            }

            if (!isset($view['theme'])) {
                $theme = app('App\Theme\Theme');
                $view->with('theme', $theme);
            }

            if (!isset($view['user'])) {
                $guard = app('auth');
                $view->with('user', $guard->user());
            }
        });
    }

    protected function extendQueues()
    {
        $this->app['queue']->extend('redis', function () {
            return new RedisConnector(app('redis'));
        });
    }

    protected function extendCache()
    {
        $this->app->extend('cache', function(){
            return new CacheManager(app());
        });
    }

    protected function bladeCopyright()
    {
        /*
         * using facade, since it's actually not bound straight to the container
         */
        Blade::directive('copyright', function ($expression) {

            $format = "%s &copy; <a target=\"_blank\" href=\"%s\">%s</a> All Rights Reserved.";

            return sprintf($format, \Carbon\Carbon::now()->format('Y'), "http://digiredo.be", "Digiredo");
        });
    }

    protected function automateUriCleanup()
    {
        $this->app['events']->listen('eloquent.deleted: *', 'App\System\Uri\Cleanup');
    }

}