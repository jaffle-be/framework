<?php

namespace Modules\Search\Command;

use Illuminate\Console\Command;
use Modules\Search\SearchServiceInterface;

class SearchSettings extends Command
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
