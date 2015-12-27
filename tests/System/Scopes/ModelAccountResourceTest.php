<?php

namespace Test\System\Scopes;

use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Scopes\ModelAccountResourceScope;
use Test\TestCase;

class DummyModelAccountResource
{
    public static $scopes = [];

    use ModelAccountResource;

    public static function addGlobalScope($class)
    {
        static::$scopes[get_class($class)] = true;
    }
}

class ModelAccountResourceTest extends TestCase
{
    public function testBootingScope()
    {
        DummyModelAccountResource::bootModelAccountResource();

        $scope = ModelAccountResourceScope::class;
        $this->assertArrayHasKey($scope, DummyModelAccountResource::$scopes);
        $this->assertTrue(DummyModelAccountResource::$scopes[$scope]);
    }
}
