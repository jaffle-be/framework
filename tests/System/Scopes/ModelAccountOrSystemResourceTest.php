<?php

namespace Test\System\Scopes;

use Modules\System\Scopes\ModelAccountOrSystemResource;
use Modules\System\Scopes\ModelAccountOrSystemResourceScope;
use Test\TestCase;

class DummyModelAccountOrSystemResource
{
    public static $scopes = [];

    use ModelAccountOrSystemResource;

    public static function addGlobalScope($class)
    {
        static::$scopes[get_class($class)] = true;
    }
}

class ModelAccountOrSystemResourceTest extends TestCase
{
    public function testBootingScope()
    {
        DummyModelAccountOrSystemResource::bootModelAccountOrSystemResource();

        $scope = ModelAccountOrSystemResourceScope::class;
        $this->assertArrayHasKey($scope, DummyModelAccountOrSystemResource::$scopes);
        $this->assertTrue(DummyModelAccountOrSystemResource::$scopes[$scope]);
    }
}
