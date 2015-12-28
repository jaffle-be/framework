<?php

namespace Modules\System\Providers;

use Blade;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory;
use Modules\System\Console\CompileTranslations;
use Modules\System\Console\FreshApplication;
use Modules\System\Seo\SeoManager;
use Modules\System\ServiceProvider;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;

/**
 * Class SystemServiceProvider
 * @package Modules\System\Providers
 */
class SystemServiceProvider extends ServiceProvider
{
    protected $namespace = 'system';

    public function boot()
    {
        parent::boot();

        $this->validators();

        $this->viewGlobals();

        $this->bladeCopyright();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('Pusher', function ($app) {
            $config = $this->app['config']->get('broadcasting.connections.pusher');

            return new \Pusher($config['key'], $config['secret'], $config['app_id'], array_get($config, 'options', []));
        });

        $this->app->singleton('seo', function ($app) {
            return new SeoManager($app['config']);
        });

        $this->app->bind('Modules\System\Seo\SeoManager', 'seo');

//        $this->app->booted(function ($app) {
//            $app['newrelic']->setAppName(env('APP_NAME'));
//        });

        $this->app->booted(function ($app) {
            $app['markdown.environment']->addExtension(new AttributesExtension());
        });

        $this->app->booted(function ($app) {
            $app->register('Modules\System\Uri\UriServiceProvider');
        });

        $this->commands([FreshApplication::class, CompileTranslations::class]);
    }

    protected function listeners()
    {
        $this->automateUriMaintenance();
        $this->automateShortcodeFormatting();
        $this->pushableListeners();
        $this->automatePresentableCaching();
    }

    protected function validators()
    {
        $this->app->make('validator')->extend('vat', 'Modules\System\Validators\Vat@validate');
    }

    /**
     *
     */
    protected function viewGlobals()
    {
        /* @var Factory $view */
        $this->app['view']->composer('*', function (View $view) {

            if (! isset($view['account'])) {
                $accounts = app('Modules\Account\AccountManager');
                $view->with('account', $accounts->account());
            }

            if (! isset($view['theme'])) {
                $theme = app('Modules\Theme\Theme');
                $view->with('theme', $theme);
            }

            if (! isset($view['user'])) {
                $guard = app('auth');
                $view->with('user', $guard->user());
            }
        });
    }

    protected function bladeCopyright()
    {
        /*
         * using facade, since it's actually not bound straight to the container
         */
        Blade::directive('copyright', function ($expression) {

            $format = '%s &copy; <a target="_blank" href="%s">%s</a> All Rights Reserved.';

            return sprintf($format, \Carbon\Carbon::now()->format('Y'), 'http://digiredo.be', 'Digiredo');
        });
    }

    protected function automateUriMaintenance()
    {
        $this->app['events']->listen('eloquent.deleting: *', 'Modules\System\Uri\CleanupPrepping');
        $this->app['events']->listen('eloquent.deleted: *', 'Modules\System\Uri\Cleanup');
        $this->app['events']->listen('eloquent.created: *', 'Modules\System\Uri\Creator');
    }

    protected function automateShortcodeFormatting()
    {
        $this->app['events']->listen('eloquent.saving: *', 'Modules\System\Presenter\ShortCodeFormatter');
    }

    protected function pushableListeners()
    {
        $this->app['events']->listen('eloquent.deleted: *', 'Modules\System\Pushable\PushableManager@deleted');
        $this->app['events']->listen('eloquent.created: *', 'Modules\System\Pushable\PushableManager@created');
        $this->app['events']->listen('eloquent.updated: *', 'Modules\System\Pushable\PushableManager@updated');
        $this->app['events']->listen('eloquent.attached: *', 'Modules\System\Pushable\PushableManager@attached');
        $this->app['events']->listen('eloquent.detached: *', 'Modules\System\Pushable\PushableManager@detached');
    }

    protected function automatePresentableCaching()
    {
        $this->app['events']->listen('eloquent.saving: *', 'Modules\System\Presenter\PresentableCacher');
    }
}
