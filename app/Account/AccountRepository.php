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
        if(empty($domain))
            return null;

        return $this->account->where('domain', $domain)
            ->take(1)->first();
    }

}