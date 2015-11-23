<?php namespace Modules\Shop\Gamma;

use Illuminate\Support\Collection;
use Modules\Account\Account;
use Modules\Account\AccountManager;

class GammaSubscriptionManager
{
    protected $accounts;

    public function __construct(AccountManager $accounts)
    {
        $this->accounts = $accounts;
    }

    public function getSubscribedAccounts(Account $account = null)
    {
        $account = $this->defaultAccount($account);

        $digiredo = $this->baseAccount($account);

        //for now, shops are hardcoded to subscribe to digiredo and themselves.
        if($account->alias == $digiredo->alias)
        {
            return new Collection([$digiredo]);
        }
        else{
            return new Collection([$digiredo, $account]);
        }
    }

    public function subscribedIds($account = null)
    {
        return $this->getSubscribedAccounts($account)->lists('id')->toArray();
    }

    /**
     * @param Account|null $account
     *
     * @return bool|Account
     */
    protected function defaultAccount($account)
    {
        if($account){
            return $account;
        }

        return $this->accounts->account();
    }

    /**
     * @param Account $account
     *
     * @return mixed
     * @throws \Exception
     */
    protected function baseAccount(Account $account)
    {
        $digiredo = $account->newQueryWithoutScopes()->whereAlias('digiredo')->first();

        if (!$digiredo) {
            throw new \Exception('No default subscription account detected');
        }

        return $digiredo;
    }

}