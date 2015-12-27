<?php

namespace Modules\Account;

use Modules\Search\SearchService;

/**
 * Class IndexManager
 * @package Modules\Account
 */
class IndexManager
{
    protected $search;

    protected $account;

    /**
     * @param SearchService $search
     * @param Account $account
     */
    public function __construct(SearchService $search, Account $account)
    {
        $this->search = $search;
        $this->account = $account;
    }

    /**
     * @param Account $account
     */
    public function remove(Account $account)
    {
        $client = $this->search->getClient();

        $client->indices()->updateAliases([
            'body' => [
                'actions' => [
                    [
                        'remove' => [
                            'index' => config('search.index'),
                            'alias' => $account->alias,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function allAliases()
    {
        foreach ($this->account->all() as $account) {
            $this->add($account);
        }
    }

    /**
     * @param Account $account
     */
    public function add(Account $account)
    {
        $client = $this->search->getClient();

        $client->indices()->updateAliases([
            'body' => [
                'actions' => [
                    [
                        'add' => [
                            'index' => config('search.index'),
                            'alias' => [
                                'alias' => $account->alias,
                                'routing' => $account->id,
                                'filter' => [
                                    'term' => [
                                        'account_id' => $account->id,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: '.Account::class, __CLASS__.'@add');
        $events->listen('eloquent.updating: '.Account::class, __CLASS__.'@remove');
        $events->listen('eloquent.updated: '.Account::class, __CLASS__.'@add');
        $events->listen('eloquent.deleted: '.Account::class, __CLASS__.'@remove');
    }
}
