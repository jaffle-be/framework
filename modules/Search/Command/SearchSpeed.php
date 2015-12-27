<?php

namespace Modules\Search\Command;

use Illuminate\Console\Command;
use Modules\Search\Config;
use Modules\Search\SearchServiceInterface;

class SearchSpeed extends Command
{
    protected $signature = 'search:speed {speed?}';

    protected $description = 'set the refresh_interval for elasticsearch';

    /**
     * @var SearchServiceInterface
     */
    protected $search;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(SearchServiceInterface $search, Config $config)
    {
        parent::__construct();

        $this->search = $search;

        $this->config = $config;
    }

    public function handle()
    {
        $client = $this->search->getClient();

        $speed = $this->argument('speed') ? $this->argument('speed') : $this->config->getSpeed();

        $settings = [
            'index' => $this->config->getIndex(),
            'body' => [
                'index' => [
                    'refresh_interval' => $speed,
                ],
            ],
        ];

        $client->indices()->putSettings($settings);
    }
}
