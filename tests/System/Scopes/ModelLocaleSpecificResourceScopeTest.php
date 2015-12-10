<?php namespace Test\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Locale;
use Modules\System\Scopes\ModelLocaleSpecificResourceScope;
use Test\TestCase;
use Mockery as m;

class ModelLocaleSpecificResourceScopeTest extends TestCase
{

    public function testItWillNotAdjustQueryWhenNoLocalesSpecified()
    {
        $currentLocale = app()->getLocale();

        $locale = m::mock(Locale::class);
        $locale->shouldReceive('where')->once()->with('slug', $currentLocale)->andReturnSelf();
        $locale->shouldReceive('first')->once()->andReturnNull();

        $builder = m::mock(Builder::class);
        $model = m::mock(Model::class);

        $scope = new ModelLocaleSpecificResourceScope($locale);
        $scope->apply($builder, $model);
    }

    public function testTheQuery()
    {
        $currentLocale = app()->getLocale();

        $dbLocaleMock = m::mock(Locale::class);
        $dbLocaleMock->shouldReceive('getKey')->once()->andReturn(99);

        $locale = m::mock(Locale::class);
        $locale->shouldReceive('where')->once()->with('slug', $currentLocale)->andReturnSelf();
        $locale->shouldReceive('first')->once()->andReturn($dbLocaleMock);


        $builder = m::mock(Builder::class);
        $builder->shouldReceive('where')->once()->with('locale_id', 99);

        $model = m::mock(Model::class);

        $scope = new ModelLocaleSpecificResourceScope($locale);
        $scope->apply($builder, $model);
    }

}