<?php

namespace Modules\Search\Providers;

use Elasticsearch\ClientBuilder;
use Modules\Search\Config;
use Modules\Search\SearchService;
use Modules\System\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{

    protected $namespace = 'search';

    protected function listeners()
    {
        //keep this in the boot section so we bind to the event dispatcher actually used in the eloquent model instances.
        $this->app['Modules\Search\SearchServiceInterface']->boot();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerService();

        $this->app->bind('Modules\Search\SearchServiceInterface', 'Modules\Search\SearchService');

        $this->registerCommands();
    }

    protected function registerService()
    {
        $this->app[Config::class] = new Config(config('search'));

        $this->app['Modules\Search\SearchService'] = $this->app->share(function ($app) {

            $config = $app[Config::class];

            $client = ClientBuilder::create()
                ->setHosts(config('search.hosts'))
                ->build();

            $service = new SearchService($app, $client, $config);

            return $service;
        });
    }

    protected function registerCommands()
    {
        $this->commands([
            \Modules\Search\Command\SearchBuild::class,
            \Modules\Search\Command\SearchFlush::class,
            \Modules\Search\Command\SearchSettings::class,
            \Modules\Search\Command\SearchRebuild::class,
            \Modules\Search\Command\SearchSpeed::class,
        ]);
    }
}
