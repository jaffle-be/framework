<?php

namespace Modules\Account;

use Illuminate\Contracts\Cache\Repository;

class CachedAccountRepository implements AccountRepositoryInterface
{

    protected $account;

    public function __construct(AccountRepository $account, Repository $cache)
    {
        $this->account = $account;
        $this->cache = $cache;
    }

    public function findByAlias($alias)
    {
        return $this->cache->sear('account', function () use ($alias) {
            return $this->account->findByAlias($alias);
        });
    }

    public function findByDomain($domain)
    {
        return $this->account->findByDomain($domain);
    }

    /**
     * @return Account
     */
    public function newAccount(array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function __call($name, $arguments)
    {
        $result = call_user_func_array([$this->account, $name], $arguments);

        $this->updated();

        return $result;
    }

    public function updated()
    {
        $this->cache->forget('account');
    }

    /**
     * Find the base account that's being used as the 'system' account.
     *
     * @return mixed
     */
    public function baseAccount()
    {
        return $this->account->baseAccount();
    }
}
