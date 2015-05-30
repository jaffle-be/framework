<?php namespace App\Users;

use Jaffle\Tools\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    protected $namespace = 'users';

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