<?php

namespace App\Account;

class AccountRepository
{

    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
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

        return $this->account->where('alias', $alias)
            ->take(1)->first();
    }

}