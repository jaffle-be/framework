<?php

namespace Modules\Account;

use Illuminate\Contracts\Cache\Repository;

/**
 * Class AccountRepository
 * @package Modules\Account
 */
class AccountRepository implements AccountRepositoryInterface
{
    protected $account;

    /**
     * @param Account $account
     * @param Repository $cache
     */
    public function __construct(Account $account, Repository $cache)
    {
        $this->account = $account;
        $this->cache = $cache;
    }

    /**
     * @param $domain
     */
    public function findByDomain($domain)
    {
        if (empty($domain)) {
            return;
        }

        return $this->account->where('domain', $domain)
            ->take(1)->first();
    }

    /**
     * @param array $payload
     * @return static
     */
    public function newAccount(array $payload)
    {
        return $this->account->create($payload);
    }

    /**
     * The alias represents the subdomain for the main app url an account is running under.
     *
     * $domain
     * @param $alias
     */
    public function findByAlias($alias)
    {
        if (empty($alias)) {
            return;
        }

        $account = $this->account->with(['contactInformation', 'contactInformation.address', 'socialLinks', 'locales', 'locales.translations'])->where('alias', $alias)
            ->take(1)->first();

        //make sure we always have a contactInformation, when we need to link address using google maps plugin
        if ($account) {
            $contact = $account->contactInformation->first();

            if (! $contact) {
                $contact = $account->contactInformation()->create([]);
            }
        }

        return $account;
    }

    public function updated()
    {
    }

    /**
     * Find the base account that's being used as the 'system' account.
     *
     *
     * @throws \Exception
     */
    public function baseAccount()
    {
        $digiredo = $this->account->newQueryWithoutScopes()->whereAlias('digiredo')->first();

        if (! $digiredo) {
            throw new \Exception('No default subscription account detected');
        }

        return $digiredo;
    }
}
