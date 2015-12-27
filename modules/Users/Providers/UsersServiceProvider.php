<?php namespace Modules\Users\Providers;

use Carbon\Carbon;
use Illuminate\Cache\Repository;
use Illuminate\Redis\Database;
use Modules\Users\Auth\Throttler\ThrottleManager;
use Modules\System\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{

    protected $namespace = 'users';

    public function register()
    {
        $this->app->bind('Modules\Users\Contracts\UserRepositoryInterface', 'Modules\Users\UserRepository');
        $this->app->bind('Modules\Users\Contracts\TokenRepositoryInterface', 'Modules\Users\Auth\Tokens\TokenRepository');
        $this->app->bind('Modules\Users\Contracts\Throttler', 'Modules\Users\Auth\Throttler\ThrottleManager');

        $this->bindAuthThrottler();
    }

    protected function listeners()
    {
        $events = $this->app['events'];

        $events->listen('Modules\Users\Auth\Events\UserRegistered', 'Modules\Users\Auth\Handlers\UserRegisteredHandler');
    }

    protected function bindAuthThrottler()
    {
        $this->app->singleton(ThrottleManager::class, function()
        {
            /* @var $redis Database */
            $redis = app('redis')->connection(config('cache.stores.redis.connection'));

            $queue = app('queue')->connection();

            return new ThrottleManager($redis, app('config'), $queue, new Carbon(), app('request'));
        });
    }
}