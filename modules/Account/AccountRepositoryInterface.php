<?php

namespace Modules\Account;

/**
 * Interface AccountRepositoryInterface
 * @package Modules\Account
 */
interface AccountRepositoryInterface
{
    /**
     * @param $domain
     * @return mixed
     */
    public function findByDomain($domain);

    /**
     * @param array $payload
     * @return
     */
    public function newAccount(array $payload);

    /**
     * The alias represents the subdomain for the main app url an account is running under.
     *
     *
     * $domain
     * @param $alias
     * @return
     */
    public function findByAlias($alias);

    /**
     * Find the base account that's being used as the 'system' account.
     *
     *
     */
    public function baseAccount();

    /**
     * method used to trigger cache update.
     */
    public function updated();
}
