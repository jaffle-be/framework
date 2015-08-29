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
            $this->app->booted(function ($app) {
                $app['App\Account\AccountManager']->boot($app['request']);
            });

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

        $this->app->bind('App\Account\AccountRepositoryInterface', 'App\Account\CachedAccountRepository');
    }

    protected function listeners()
    {
        $this->cacheBusting();
    }

    protected function observers()
    {
    }

    protected function cacheBusting()
    {
        $this->app['events']->listen('eloquent.saved: App\\Contact\\Address', function($address)
        {
            if($address->owner_type == AccountContactInformation::class)
            {
                $this->app['App\Account\AccountManager']->updated();
            }
        });

        $this->app['events']->listen('eloquent.saved: App\\Contact\\SocialLinks', function($links)
        {
            if($links->owner_type == Account::class)
            {
                $this->app['App\Account\AccountManager']->updated();
            }
        });

        $this->app['events']->listen('eloquent.saved: App\\Media\\Image', function($image)
        {
            if($image->owner_type == AccountLogo::class)
            {
                app('cache')->forget('account-logo');
            }
        });
    }

}