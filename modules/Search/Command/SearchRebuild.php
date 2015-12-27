<?php

namespace Modules\Search\Command;

use Illuminate\Console\Command;
use Modules\Search\SearchServiceInterface;

/**
 * Class SearchRebuild
 * @package Modules\Search\Command
 */
class SearchRebuild extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'rebuild the index for the elasticsearch instance.';

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
        $this->call('search:flush');
        $this->call('search:settings');
        $this->call('search:build');
    }
}
