<?php

namespace Modules\Account;

use Illuminate\Contracts\Cache\Repository;

/**
 * Class CachedAccountRepository
 * @package Modules\Account
 */
class CachedAccountRepository implements AccountRepositoryInterface
{
    protected $account;

    /**
     * @param AccountRepository $account
     * @param Repository $cache
     */
    public function __construct(AccountRepository $account, Repository $cache)
    {
        $this->account = $account;
        $this->cache = $cache;
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function findByAlias($alias)
    {
        return $this->cache->sear('account', function () use ($alias) {
            return $this->account->findByAlias($alias);
        });
    }

    /**
     * @param $domain
     * @return mixed|void
     */
    public function findByDomain($domain)
    {
        return $this->account->findByDomain($domain);
    }

    /**
     * @param array $payload
     * @return mixed
     */
    public function newAccount(array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
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
     *
     */
    public function baseAccount()
    {
        return $this->account->baseAccount();
    }
}
