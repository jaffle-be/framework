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
        //we can simply inject the account based of the subdomain that's been set.
        $subdomain = $this->config->get('app.subdomain');

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