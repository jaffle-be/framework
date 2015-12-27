<?php

namespace Test\System\Scopes;

use Illuminate\Http\Request;
use Modules\System\Scopes\LocalisedResourceCollection;
use Modules\System\Scopes\ModelLocaleSpecificResource;
use Modules\System\Scopes\ModelLocaleSpecificResourceScope;
use Test\TestCase;
use Mockery as m;

class DummyModelLocaleSpecificResource
{
    public static $scopes = [];

    use ModelLocaleSpecificResource;

    public static function addGlobalScope($class)
    {
        static::$scopes[get_class($class)] = true;
    }
}

class ModelLocaleSpecificResourceTest extends TestCase
{
    public function testBootingScopeWontWorkInConsole()
    {
        DummyModelLocaleSpecificResource::bootModelLocaleSpecificResource();

        $scope = ModelLocaleSpecificResourceScope::class;
        $this->assertArrayHasKey($scope, DummyModelLocaleSpecificResource::$scopes);
        $this->assertTrue(DummyModelLocaleSpecificResource::$scopes[$scope]);
    }

    public function testScopeWontBootInAdminAndApi()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('getRequestUri')->once()->andReturn('some random request uri');
        $this->app['request'] = $request;

        DummyModelLocaleSpecificResource::bootModelLocaleSpecificResource();
        $this->hasScope();
        $this->resetScope();

        $request->shouldReceive('getRequestUri')->once()->andReturn('/admin');
        DummyModelLocaleSpecificResource::bootModelLocaleSpecificResource();
        $this->hasNoScope();

        $request->shouldReceive('getRequestUri')->once()->andReturn('/api');
        DummyModelLocaleSpecificResource::bootModelLocaleSpecificResource();
        $this->hasNoScope();
    }

    public function testANewCollectionIsALocalisedResourceCollection()
    {
        $test = new DummyModelLocaleSpecificResource();
        $collection = $test->newCollection([$test]);
        $this->assertInstanceOf(LocalisedResourceCollection::class, $collection);
    }

    protected function hasScope()
    {
        $scope = ModelLocaleSpecificResourceScope::class;
        $this->assertArrayHasKey($scope, DummyModelLocaleSpecificResource::$scopes);
        $this->assertTrue(DummyModelLocaleSpecificResource::$scopes[$scope]);
    }

    protected function resetScope()
    {
        DummyModelLocaleSpecificResource::$scopes = [];
    }

    protected function hasNoScope()
    {
        $scope = ModelLocaleSpecificResourceScope::class;
        $this->assertArrayNotHasKey($scope, DummyModelLocaleSpecificResource::$scopes);
    }
}
