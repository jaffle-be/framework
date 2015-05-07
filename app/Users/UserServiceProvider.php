<?php namespace App\Users;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //include our routes
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'users');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'users');
        $this->mergeConfigFrom(__DIR__ . '/config/users.php', 'users');

        //event listeners
        $this->listeners();
    }

    public function register()
    {
        $this->app->bind('App\Users\Contracts\UserRepositoryInterface', 'App\Users\UserRepository');
        $this->app->bind('App\Users\Contracts\TokenRepositoryInterface', 'App\Users\Auth\Tokens\TokenRepository');
        $this->app->bind('App\Users\Contracts\Throttler', 'App\Users\Auth\Throttler\ThrottleManager');
    }

    protected function listeners()
    {
        $events = $this->app['events'];

        $events->listen('App\Users\Auth\Events\UserRegistered', 'App\Users\Auth\Handlers\UserRegisteredHandler');
    }
}