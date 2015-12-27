<?php

namespace Test\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Scopes\ModelAutoSortScope;
use Test\TestCase;
use Mockery as m;

class DummyAutoSortUsingDefaults extends Model
{
    use ModelAutoSort;
}

class DummyAutoSortUsingStringDefinedValue extends Model
{
    public $autosort = 'fieldname';

    use ModelAutoSort;
}

class DummyAutoSortUsingArrayDefinedValues extends Model
{
    public $autosort = ['fieldname', 'desc'];

    use ModelAutoSort;
}

class ModelAutoSortScopeTest extends TestCase
{
    public function testItUsesTheCorrectDefaults()
    {
        $scope = new ModelAutoSortScope();
        $model = new DummyAutoSortUsingDefaults();

        $builder = m::mock(Builder::class);
        $builder->shouldReceive('orderBy')->with('sort', 'asc')->once();
        $scope->apply($builder, $model);
    }

    public function DummyAutoSortUsingStringDefinedValue()
    {
        $scope = new ModelAutoSortScope();
        $model = new testItWorksUsingStringValue();

        $builder = m::mock(Builder::class);
        $builder->shouldReceive('orderBy')->with('fieldname', 'asc')->once();
        $scope->apply($builder, $model);
    }

    public function testItWorksUsingArrayDefinition()
    {
        $scope = new ModelAutoSortScope();
        $model = new DummyAutoSortUsingArrayDefinedValues();

        $builder = m::mock(Builder::class);
        $builder->shouldReceive('orderBy')->with('fieldname', 'desc')->once();
        $scope->apply($builder, $model);
    }
}
