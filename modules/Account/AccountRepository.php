<?php

namespace Modules\Account;

use Illuminate\Contracts\Cache\Repository;

class AccountRepository implements AccountRepositoryInterface
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

        $account = $this->account->with(['contactInformation', 'contactInformation.address', 'socialLinks', 'locales', 'locales.translations'])->where('alias', $alias)
            ->take(1)->first();

        //make sure we always have a contactInformation, when we need to link address using google maps plugin
        $contact = $account->contactInformation->first();

        if(!$contact)
        {
            $contact = $account->contactInformation()->create([]);
        }

        return $account;
    }

    public function updated()
    {

    }

}