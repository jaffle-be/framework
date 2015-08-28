<?php

namespace App\System;

use App\System\Queue\RedisConnector;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory;
use Blade;

class SystemServiceProvider extends ServiceProvider
{

    protected $namespace = 'system';

    public function boot()
    {
        parent::boot();
        $this->validators();

        $this->viewGlobals();
        //using facade, since it's actually not bound straight to the container
        Blade::directive('copyright', function($expression) {

            $format = "%s &copy; <a target=\"_blank\" href=\"%s\">%s</a> All Rights Reserved.";

            return sprintf($format, \Carbon\Carbon::now()->format('Y'), "http://digiredo.be", "Digiredo");
        });

        $this->app['queue']->extend('redis', function (){
            return new RedisConnector(app('redis'));
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
            __DIR__ . '/config/system.php', 'system'
        );

        $this->app->booted(function ($app) {
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

}