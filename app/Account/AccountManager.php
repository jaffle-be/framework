<?php

namespace App\Account;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class AccountManager {

    protected $repo;

    protected $config;

    protected $system;

    protected $account = false;

    public function __construct(AccountRepository $account, Repository $config)
    {
        $this->repo = $account;

        $this->config = $config;
    }

    public function boot(Request $request)
    {
        //do we need to do an account injection?
        if($this->requestNeedsAccount($request))
        {
            //find the account based on the given domain.
            $account = $this->repo->findByDomain($this->config->get('app.subdomain'));

            $this->account = $account;
        }
    }

    public function account()
    {
        return $this->account;
    }

    protected function requestNeedsAccount(Request $request)
    {
        //the request needs an account if the hosts second parameter after a split of the host name
        //equals the first part of our application url.
        //@todo this should be changed to needing a subdomain based on the given subdomain parameter.
        //the below filtering way is pretty dirty.
        $app = $this->getAppSection();

        $current = $this->getCurrentSection($request);

        return $app == $current;
    }

    protected function getAppSection()
    {
        $app = $this->config->get('app.url');

        $app = preg_replace('#https?://#', '', $app);

        $app = explode('.', $app);

        $app = array_shift($app);

        return $app;
    }

    protected function getCurrentSection(Request $request)
    {
        $current = explode('.', $request->getHost());

        array_shift($current);

        return array_shift($current);
    }

}