<?php namespace Test\System\Cache;

use Illuminate\Cache\Repository;
use Modules\System\Cache\CacheManager;
use Test\TestCase;

class CacheManagerTest extends TestCase
{

    public function testGettingPrefixReturnsCorrectFormat()
    {
        /* @var $cache CacheManager */
        $cache = app('cache');

        /** @var Repository $redis need to specifiy redis, since for testing we use arraystore by default, and that will return '' as prefix */
        $redis = $cache->driver('redis');

        $store = $redis->getStore();
        $prefix = $store->getPrefix();

        $this->assertSame('cache:digiredo-testing:digiredo:', $prefix);
    }

}