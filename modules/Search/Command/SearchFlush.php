<?php

namespace Modules\Search\Command;

use Illuminate\Console\Command;
use Modules\Search\SearchServiceInterface;

/**
 * Class SearchFlush
 * @package Modules\Search\Command
 */
class SearchFlush extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the entire index';

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
        $this->service->flush();
    }
}
