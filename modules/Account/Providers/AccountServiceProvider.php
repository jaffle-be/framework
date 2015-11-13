<?php namespace Modules\Account\Providers;

use Modules\Account\Account;
use Modules\Account\AccountContactInformation;
use Modules\Account\AccountLogo;
use Pingpong\Modules\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $namespace = 'account';

    public function boot()
    {
        parent::boot();

        if(config('system.installed'))
        {
            $this->app['Modules\Account\AccountManager']->boot();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Modules\Account\AccountManager');

        $this->app->bind('Modules\Account\AccountRepositoryInterface', 'Modules\Account\CachedAccountRepository');
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
        $this->app['events']->listen('eloquent.saved: Modules\\Contact\\Address', function ($address) {
            if ($address->owner_type == AccountContactInformation::class) {
                $this->app['Modules\Account\AccountManager']->updated();
            }
        });

        $this->app['events']->listen('eloquent.saved: Modules\\Contact\\SocialLinks', function ($links) {
            if ($links->owner_type == Account::class) {
                $this->app['Modules\Account\AccountManager']->updated();
            }
        });

        $this->app['events']->listen('eloquent.saved: Modules\\Media\\Image', function ($image) {
            if ($image->owner_type == AccountLogo::class) {
                app('cache')->forget('account-logo');
            }
        });
    }

}