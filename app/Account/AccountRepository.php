<?php

namespace App\Account;

use Illuminate\Contracts\Cache\Repository;

class AccountRepository
{

    protected $account;

    public function __construct(Account $account, Repository $cache)
    {
        $this->account = $account;
        $this->cache = $cache;
    }

    public function findByDomain($domain)
    {
        if (empty($domain)) {
            return null;
        }

        return $this->account->where('domain', $domain)
            ->take(1)->first();
    }

    /**
     * @param array $payload
     *
     * @return Account
     */
    public function newAccount(array $payload)
    {
        return $this->account->create($payload);
    }

    /**
     * The alias represents the subdomain for the main app url an account is running under
     *
     * @param $domain
     */
    public function findByAlias($alias)
    {
        if (empty($alias)) {
            return null;
        }

        return $this->cache->sear('account', function() use ($alias){
            return $this->account->with(['contactInformation', 'contactInformation.address', 'socialLinks'])->where('alias', $alias)
                ->take(1)->first();
        });
    }

}