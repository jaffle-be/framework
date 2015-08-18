<?php

namespace App\Account;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class AccountManager
{

    protected $repo;

    protected $config;

    protected $account = false;

    public function __construct(AccountRepository $account, Repository $config, Application $application)
    {
        $this->repo = $account;

        $this->config = $config;

        $this->application = $application;
    }

    public function boot(Request $request)
    {
        //this alias should be set using your apache or nginx config.
        //we set the default to our own application.
        $subdomain = env('APP_ALIAS', 'digiredo');

        $this->account = $this->repo->findByAlias($subdomain);

        return $this->account;
    }

    /**
     * @return Account|bool
     */
    public function account()
    {
        return $this->account;
    }

}