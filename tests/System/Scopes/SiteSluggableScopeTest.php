<?php

namespace Test\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Account;
use Modules\System\Scopes\SiteSluggableScope;
use Modules\System\Sluggable\SiteSluggable;
use Test\TestCase;
use Mockery as m;

class SqlDummySiteSluggableScope extends Model
{
    use SiteSluggable;

    public function getAccount()
    {
        return new Account();
    }

    public function getTable()
    {
        return 'tablename';
    }

    public function getKeyName()
    {
        return 'keyname';
    }
}

class SiteSluggableScopeTest extends TestCase
{
    public function testItJoinsWithTheUriTable()
    {
        $scope = new SiteSluggableScope();

        $builder = m::mock(Builder::class);

        $builder->shouldReceive('join')->once()->with('uris', m::on(function ($argument) {
            return $argument instanceof \Closure;
        }))->andReturnSelf();

        $builder->shouldReceive('select')->once()->with(['table.*', 'uris.uri'])->andReturnSelf();

        $model = m::mock(Model::class);
        $model->shouldReceive('getTable')->once()->andReturn('table');

        $scope->apply($builder, $model);
    }

    public function testTheJoinClauseAddsTheCorrectScope()
    {
        $dummy = new SqlDummySiteSluggableScope();
        $query = $dummy->newQuery()->toSql();

        $expected = 'select `tablename`.*, `uris`.`uri` from `tablename` inner join `uris` on `uris`.`owner_type` = ? and `uris`.`owner_id` = `tablename`.`keyname`';
        $this->assertSame($expected, $query);
    }
}
