<?php

namespace Modules\Shop\Gamma;

use Illuminate\Support\Collection;
use Modules\Account\Account;
use Modules\Account\AccountManager;
use Modules\Account\AccountRepositoryInterface;

class GammaSubscriptionManager
{

    protected $accounts;

    protected $repo;

    public function __construct(AccountManager $accounts, AccountRepositoryInterface $repo)
    {
        $this->accounts = $accounts;
        $this->repo = $repo;
    }

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

    public function subscribedIds($account = null)
    {
        return $this->subscribedAccounts($account)->lists('id')->toArray();
    }

    /**
     * @return bool|Account
     */
    protected function defaultAccount($account)
    {
        if ($account) {
            return $account;
        }

        return $this->accounts->account();
    }
}
