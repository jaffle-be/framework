<?php

namespace App\System;

use App\System\Queue\RedisConnector;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory;

class SystemServiceProvider extends ServiceProvider{

    protected $namespace = 'system';

    public function boot()
    {
        parent::boot();
        $this->validators();

        $app = $this->app;

        /** @var Factory $view */
        $this->app['view']->composer('*', function(View $view) use ($app)
        {
            $accounts = $this->app->make('App\Account\AccountManager');

            $theme = $this->app->make('App\Theme\Theme');

            $guard = $this->app->make('auth');

            $view->with([
                'account' => $accounts->account(),
                'theme' => $theme,
                'user' => $guard->user()
            ]);
        });

        $this->app['queue']->extend('redis', function() use ($app){
            return new RedisConnector($app['redis']);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/system.php', 'system'
        );

        $this->app->booted(function($app){
            $app['newrelic']->setAppName(env('APP_NAME'));
        });
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
    }

    protected function validators()
    {
        $this->app->make('validator')->extend('vat', 'App\System\Validators\Vat@validate');
    }

}