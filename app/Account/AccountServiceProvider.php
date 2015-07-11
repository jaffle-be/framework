<?php namespace App\Account;

use Jaffle\Tools\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{

    protected $namespace = 'account';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Account\AccountManager');
    }

    protected function listeners()
    {
    }

    protected function observers()
    {
    }
}