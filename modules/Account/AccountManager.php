<?php

namespace Modules\Account;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

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

    public function boot(Request $request)
    {
        //this alias should be set using your apache or nginx config.
        //we set the default to our own application.
        $subdomain = env('APP_ALIAS');

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

    function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }

}