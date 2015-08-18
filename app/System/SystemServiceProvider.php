<?php

namespace App\System;

use Illuminate\Contracts\View\View;
use Illuminate\View\Factory;
use Jaffle\Tools\ServiceProvider;

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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

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