<?php

namespace Modules\Shop\Gamma;

use Illuminate\Support\Collection;
use Modules\Account\Account;
use Modules\Account\AccountManager;
use Modules\Account\AccountRepositoryInterface;

/**
 * Class GammaSubscriptionManager
 * @package Modules\Shop\Gamma
 */
class GammaSubscriptionManager
{
    protected $accounts;

    protected $repo;

    /**
     * @param AccountManager $accounts
     * @param AccountRepositoryInterface $repo
     */
    public function __construct(AccountManager $accounts, AccountRepositoryInterface $repo)
    {
        $this->accounts = $accounts;
        $this->repo = $repo;
    }

    /**
     * @param Account|null $account
     * @return Collection
     */
    public function subscribedAccounts(Account $account = null)
    {
        $account = $this->defaultAccount($account);

        $digiredo = $this->repo->baseAccount();

        //for now, shops are hardcoded to subscribe to digiredo and themselves.
        if ($account->alias == $digiredo->alias) {
            return new Collection([$digiredo]);
        } else {
            return new Collection([$digiredo, $account]);
        }
    }

    /**
     * @param null $account
     * @return array
     */
    public function subscribedIds($account = null)
    {
        return $this->subscribedAccounts($account)->lists('id')->toArray();
    }

    /**
     * @param $account
     * @return bool
     */
    protected function defaultAccount($account)
    {
        if ($account) {
            return $account;
        }

        return $this->accounts->account();
    }
}
