<?php namespace App\System\Cache;

use Illuminate\Support\Arr;

class CacheManager extends \Illuminate\Cache\CacheManager
{
    protected $account;

    /**
     * Get the cache prefix.
     *
     * @param  array $config
     *
     * @return string
     */
    protected function getPrefix(array $config)
    {
        if($this->app->runningInConsole())
        {
            $identifier = 'console';
        }
        else{
            $identifier = env('APP_ALIAS');
        }

        return sprintf('cache:%s:%s', Arr::get($config, 'prefix') ?: $this->app['config']['cache.prefix'], $identifier);
    }

}