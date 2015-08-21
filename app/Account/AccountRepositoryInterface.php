<?php namespace App\Account;

interface AccountRepositoryInterface
{

    public function findByDomain($domain);


    /**
     * @param array $payload
     *
     * @return Account
     */
    public function newAccount(array $payload);

    /**
     * The alias represents the subdomain for the main app url an account is running under
     *
     * @param $domain
     */
    public function findByAlias($alias);

    /**
     * method used to trigger cache update
     */
    public function updated();

}