<?php

namespace Modules\Search\Providers;

use Elasticsearch\ClientBuilder;
use Modules\Search\Config;
use Modules\Search\SearchService;
use Pingpong\Modules\ServiceProvider;

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
     *
     * @return void
     */
    public function register()
    {
        $this->registerService();

        $this->app->bind('Modules\Search\SearchServiceInterface', 'Modules\Search\SearchService');

        $this->registerCommands();
    }

    protected function registerService()
    {
        $this->app['Modules\Search\SearchService'] = $this->app->share(function ($app) {

            $config = new Config(config('search'));

            $client = ClientBuilder::create()
                ->setHosts(config('search.hosts'))
                ->build();

            $service = new SearchService($app, $client, $config);

            return $service;
        });
    }

    protected function registerCommands()
    {
        $this->commands(['Modules\Search\Command\SearchBuild', 'Modules\Search\Command\SearchFlush', 'Modules\Search\Command\SearchSettings', 'Modules\Search\Command\SearchRebuild']);
    }

}