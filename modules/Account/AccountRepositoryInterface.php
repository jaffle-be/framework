<?php

namespace Modules\Account;

interface AccountRepositoryInterface
{

    public function findByDomain($domain);

    /**
     * @return Account
     */
    public function newAccount(array $payload);

    /**
     * The alias represents the subdomain for the main app url an account is running under.
     *
     * @return
     * @internal param $domain
     */
    public function findByAlias($alias);

    /**
     * Find the base account that's being used as the 'system' account.
     *
     * @return mixed
     */
    public function baseAccount();

    /**
     * method used to trigger cache update.
     */
    public function updated();
}
