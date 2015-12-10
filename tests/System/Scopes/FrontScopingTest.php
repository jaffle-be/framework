<?php namespace Test\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
use Modules\System\Scopes\FrontScoping;
use Test\TestCase;

Class DummyFrontScoping{

    public static $scopes = [];

    use FrontScoping;

    public static function addGlobalScope($class)
    {
        static::$scopes[get_class($class)] = true;
    }

}

class DummyFrontScopingScopeFront implements ScopeInterface{

    public function apply(Builder $builder, Model $model)
    {
    }

    public function remove(Builder $builder, Model $model)
    {
    }

}

class FrontScopingTest extends TestCase
{

    public function tearDown()
    {
        DummyFrontScoping::$scopes = [];
        parent::tearDown();
    }

    public function testBootingFrontScopeOnFrontDoesBootFrontScope()
    {
        $this->startMockingFront();
        DummyFrontScoping::bootFrontScoping();
        $scope = DummyFrontScopingScopeFront::class;
        $this->assertArrayHasKey($scope, DummyFrontScoping::$scopes);
        $this->assertTrue(DummyFrontScoping::$scopes[$scope]);
        $this->stopMockingFront();
    }

    public function testbootingFrontScopeOnBackDoesNotBootFrontScope()
    {
        DummyFrontScoping::bootFrontScoping();
        $scope = DummyFrontScopingScopeFront::class;
        $this->assertArrayNotHasKey($scope, DummyFrontScoping::$scopes);
    }

}