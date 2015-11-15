<?php namespace Modules\Users\Providers;

use Pingpong\Modules\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{

    protected $namespace = 'users';

    public function register()
    {
        $this->app->bind('Modules\Users\Contracts\UserRepositoryInterface', 'Modules\Users\UserRepository');
        $this->app->bind('Modules\Users\Contracts\TokenRepositoryInterface', 'Modules\Users\Auth\Tokens\TokenRepository');
        $this->app->bind('Modules\Users\Contracts\Throttler', 'Modules\Users\Auth\Throttler\ThrottleManager');
    }

    protected function listeners()
    {
        $events = $this->app['events'];

        $events->listen('Modules\Users\Auth\Events\UserRegistered', 'Modules\Users\Auth\Handlers\UserRegisteredHandler');
    }

    protected function observers()
    {
    }
}