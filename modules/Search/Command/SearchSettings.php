<?php

namespace Modules\Search\Command;

use Illuminate\Console\Command;
use Modules\Search\SearchServiceInterface;

/**
 * Class SearchSettings
 * @package Modules\Search\Command
 */class SearchSettings extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the settings for the elasticsearch instance.';

    /**
     * @var SearchServiceInterface
     */
    protected $service;

    /**
     * Create a new command instance.
* @param SearchServiceInterface $service
*/
    public function __construct(SearchServiceInterface $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     *
     */
    public function fire()
    {
        $settings = config('search.settings');

        $this->service->updateSettings($settings);
    }
}
