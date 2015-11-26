<?php namespace Test\Shop\Gamma;

use Illuminate\Support\Collection;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaSubscriptionManager;
use Test\AdminTestCase;
use Mockery as m;

class GammaSubscriptionManagerTest extends AdminTestCase
{

    public function testGettingIdsForNonSpecifiedAccountWillReturnIdsForTheAccountThatTheRequestWasMadeFor()
    {
        $account = factory(Account::class)->create([]);

        $mock = m::mock('Modules\Account\AccountManager');
        $mock->shouldReceive('account')
            ->once()
            ->andReturn($account);

        $base = factory(Account::class)->create([]);

        $repo = m::mock('Modules\Account\AccountRepositoryInterface');
        $repo->shouldReceive('baseAccount')
            ->andReturn($base);

        //if we dont provide account, it should use the environment one.
        $manager = new GammaSubscriptionManager($mock, $repo);
        $this->assertEquals([$base->id, $account->id], $manager->subscribedIds());
    }

    public function testGettingIdsForSpecifiedAccountWillReturnIdsForTheAccountThatWasSpecified()
    {
        $account = factory(Account::class)->create([]);

        $mock = m::mock('Modules\Account\AccountManager');
        $mock->shouldNotReceive('account');

        $base = factory(Account::class)->create([]);

        $repo = m::mock('Modules\Account\AccountRepositoryInterface');
        $repo->shouldReceive('baseAccount')
            ->andReturn($base);

        //if we dont provide account, it should use the environment one.
        $manager = new GammaSubscriptionManager($mock, $repo);
        $this->assertEquals([$base->id, $account->id], $manager->subscribedIds($account));
    }

    public function testGettingSubscribedAccountsForNonSpecifiedAccount()
    {
        $account = factory(Account::class)->create([]);

        $mock = m::mock('Modules\Account\AccountManager');
        $mock->shouldReceive('account')
            ->once()
            ->andReturn($account);

        $base = factory(Account::class)->create([]);

        $repo = m::mock('Modules\Account\AccountRepositoryInterface');
        $repo->shouldReceive('baseAccount')
            ->andReturn($base);

        //if we dont provide account, it should use the environment one.
        $manager = new GammaSubscriptionManager($mock, $repo);

        $response = $manager->subscribedAccounts();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertSameSize($response, [$base, $account]);
        $this->assertSame($base->id, $response->get(0)->id);
        $this->assertSame($account->id, $response->get(1)->id);
    }


    public function testGettingSubscribedAccountsForSpecifiedAccount()
    {
        $account = factory(Account::class)->create([]);

        $mock = m::mock('Modules\Account\AccountManager');
        $mock->shouldNotReceive('account');

        $base = factory(Account::class)->create([]);

        $repo = m::mock('Modules\Account\AccountRepositoryInterface');
        $repo->shouldReceive('baseAccount')
            ->andReturn($base);

        //if we dont provide account, it should use the environment one.
        $manager = new GammaSubscriptionManager($mock, $repo);

        $response = $manager->subscribedAccounts($account);
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertSameSize($response, [$base, $account]);
        $this->assertSame($base->id, $response->get(0)->id);
        $this->assertSame($account->id, $response->get(1)->id);
    }



}