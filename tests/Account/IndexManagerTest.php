<?php namespace Test\Account;

use Elasticsearch\Client;
use Mockery as m;
use Modules\Account\Account;
use Test\AdminTestCase;

class IndexManagerTest extends AdminTestCase
{

    public function testItSubscribesToAllNecessaryEvents()
    {
        $events = m::mock('Illuminate\Contracts\Events\Dispatcher');

        $events->shouldReceive('listen')
            ->with('eloquent.created: Modules\Account\Account', 'Modules\Account\IndexManager@add');

        $events->shouldReceive('listen')
            ->with('eloquent.updated: Modules\Account\Account', 'Modules\Account\IndexManager@add');

        $events->shouldReceive('listen')
            ->with('eloquent.updating: Modules\Account\Account', 'Modules\Account\IndexManager@remove');

        $events->shouldReceive('listen')
            ->with('eloquent.deleted: Modules\Account\Account', 'Modules\Account\IndexManager@remove');

        $manager = app('Modules\Account\IndexManager');
        $manager->subscribe($events);
    }

    public function testAddingIndex()
    {
        $account = factory(Account::class)->make([
            'alias' => 'index.index',
        ]);
        $account->id = 10000;

        $manager = app('Modules\Account\IndexManager');
        $manager->add($account);

        $search = app('Modules\Search\SearchServiceInterface');
        $client = $search->getClient();

        /** @var Client $client */
        $response = $client->indices()->existsAlias([
            'name' => 'index.index',
        ]);

        $this->assertTrue($response);
    }

    public function testRemovingIndex()
    {
        $account = factory(Account::class)->create([
            'alias' => 'index.index',
        ]);

        $manager = app('Modules\Account\IndexManager');
        $manager->remove($account);

        $search = app('Modules\Search\SearchServiceInterface');
        $client = $search->getClient();

        /** @var Client $client */
        $response = $client->indices()->existsAlias([
            'name' => $account->alias
        ]);

        $this->assertFalse($response);
    }

}