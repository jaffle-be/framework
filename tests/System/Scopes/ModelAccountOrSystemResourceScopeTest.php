<?php

namespace Test\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mockery as m;
use Modules\Account\Account;
use Modules\Account\AccountManager;
use Modules\System\Scopes\ModelAccountOrSystemResource;
use Modules\System\Scopes\ModelAccountOrSystemResourceScope;
use Test\TestCase;

class ModelAccountOrSystemResourceScopeSql extends Model
{
    use ModelAccountOrSystemResource;
    protected $table = 'test';
}

class ModelAccountOrSystemResourceScopeTest extends TestCase
{
    public function testApplyingScopeWillNotWorkWhenNoValidAccount()
    {
        $manager = $this->managerWithoutAccount();
        $scope = new ModelAccountOrSystemResourceScope($manager);

        $builder = m::mock(Builder::class);
        $model = m::mock(Model::class);

        $scope->apply($builder, $model);
    }

    public function testApplyingScopeWorksWhenValidAccount()
    {
        $manager = $this->managerWithAccount();

        $scope = new ModelAccountOrSystemResourceScope($manager);

        $builder = m::mock(Builder::class);
        $model = m::mock(Model::class);

        $builder->shouldReceive('where')->once()->with(m::on(function ($argument) {
            return $argument instanceof \Closure;
        }))->andReturnSelf();

        $scope->apply($builder, $model);
    }

    public function testAnActualQuery()
    {
        $query = new ModelAccountOrSystemResourceScopeSql();
        $query = $query->newQuery()->toSql();
        $this->assertSame('select * from `test` where (`account_id` = ? or `account_id` is null)', $query);
    }

    /**
     * @return m\MockInterface
     */
    protected function managerWithAccount()
    {
        $account = new Account();
        $account->id = 1000;
        $manager = m::mock(AccountManager::class);
        $manager->shouldReceive('account')->once()->andReturn($account);

        return $manager;
    }

    /**
     * @return m\MockInterface
     */
    protected function managerWithoutAccount()
    {
        $manager = m::mock(AccountManager::class);
        $manager->shouldReceive('account')->once()->andReturn(null);

        return $manager;
    }
}
