<?php namespace Modules\System\Cache;

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

        $prefix = Arr::get($config, 'prefix') ?: $this->app['config']['cache.prefix'];

        return sprintf('cache:%s:%s', $prefix, env('APP_ALIAS'));
    }

}