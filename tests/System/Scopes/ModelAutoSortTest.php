<?php namespace Test\System\Scopes;

use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Scopes\ModelAutoSortScope;
use Test\TestCase;

Class DummyModelAutoSort{

    public static $scopes = [];

    use ModelAutoSort;

    public static function addGlobalScope($class)
    {
        static::$scopes[get_class($class)] = true;
    }

}

class ModelAutoSortTest extends TestCase
{

    public function testBootingScope()
    {
        DummyModelAutoSort::bootModelAutoSort();

        $scope = ModelAutoSortScope::class;
        $this->assertArrayHasKey($scope, DummyModelAutoSort::$scopes);
        $this->assertTrue(DummyModelAutoSort::$scopes[$scope]);
    }

}