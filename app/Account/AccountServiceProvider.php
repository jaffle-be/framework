<?php namespace App\Account;

use App\System\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{

    protected $namespace = 'account';

    public function boot()
    {
        parent::boot();

        if(!$this->app->runningInConsole())
        {
            $this->app->make('App\Account\AccountManager')->boot($this->app['request']);
        }
    }

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