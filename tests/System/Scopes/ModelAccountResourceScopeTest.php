<?php namespace Test\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Account;
use Modules\Account\AccountManager;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Scopes\ModelAccountResourceScope;
use Test\TestCase;
use Mockery as m;

class ModelAccountResourceScopeSql extends Model
{
    use ModelAccountResource;
    protected $table = 'test';

}

class ModelAccountResourceScopeTest extends TestCase
{

    public function testApplyingScopeWillNotWorkWhenNoValidAccount()
    {
        $manager = $this->managerWithoutAccount();
        $scope = new ModelAccountResourceScope($manager);

        $builder = m::mock(Builder::class);
        $model = m::mock(Model::class);

        $scope->apply($builder, $model);
    }

    public function testApplyingScopeWorksWhenValidAccount()
    {
        $manager = $this->managerWithAccount();

        $scope = new ModelAccountResourceScope($manager);

        $builder = m::mock(Builder::class);
        $model = m::mock(Model::class);

        $builder->shouldReceive('where')->once()->with('account_id', 1000)->andReturnSelf();

        $scope->apply($builder, $model);
    }

    public function testAnActualQuery()
    {
        $query = new ModelAccountResourceScopeSql();
        $query = $query->newQuery()->toSql();
        $this->assertSame("select * from `test` where `account_id` = ?", $query);
    }

    /**
     * @return m\MockInterface
     */
    protected function managerWithAccount()
    {
        Account::unguard();
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