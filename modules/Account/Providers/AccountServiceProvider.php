<?php

namespace Modules\Account\Providers;

use Modules\Account\Account;
use Modules\Account\AccountContactInformation;
use Modules\Account\AccountLogo;
use Modules\System\ServiceProvider;

/**
 * Class AccountServiceProvider
 * @package Modules\Account\Providers
 */
class AccountServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $namespace = 'account';

    public function boot()
    {
        parent::boot();

        if (config('system.installed')) {
            $this->app['Modules\Account\AccountManager']->boot();
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('Modules\Account\AccountManager');

        $this->app->bind('Modules\Account\AccountRepositoryInterface', 'Modules\Account\CachedAccountRepository');
    }

    protected function listeners()
    {
        $this->cacheBusting();
        $this->indexers();
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

    protected function indexers()
    {
        $this->app['events']->subscribe('Modules\\Account\\IndexManager');
    }
}
