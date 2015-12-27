<?php

namespace Modules\Account;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

class AccountManager
{
    protected $repo;

    protected $config;

    protected $account = false;

    public function __construct(AccountRepositoryInterface $account, Repository $config, Application $application)
    {
        $this->repo = $account;

        $this->config = $config;

        $this->application = $application;
    }

    /**
     * Allows to hotswap account.
     */
    public function forced($account, \Closure $closure)
    {
        $previous = $this->account;

        $this->account = $account;

        $closure();

        $this->account = $previous;
    }

    public function boot()
    {
        //this alias should be set using your apache or nginx config.
        //we set the default to our own application.
        $this->account = $this->repo->findByAlias(env('APP_ALIAS'));

        return $this->account;
    }

    /**
     * @return Account|bool
     */
    public function account()
    {
        return $this->account;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}
