<?php

namespace Modules\Search\Command;

use Illuminate\Console\Command;
use Modules\Account\IndexManager;
use Modules\Search\SearchServiceInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class SearchBuild
 * @package Modules\Search\Command
 */
class SearchBuild extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build your elastic search indexes';

    /**
     * @var SearchServiceInterface
     */
    protected $service;

    /**
     * Create a new command instance.
     * @param SearchServiceInterface $service
     * @param IndexManager $indexManager
     */
    public function __construct(SearchServiceInterface $service, IndexManager $indexManager)
    {
        parent::__construct();

        $this->service = $service;

        $this->indexManager = $indexManager;
    }

    /**
     * Execute the console command.
     *
     *
     */
    public function fire()
    {
        $this->call('search:speed', ['speed' => '5m']);

        $this->indexManager->allAliases();

        $types = $this->argument('types');

        if (empty($types)) {
            $types = config('search.types');

            $types = array_keys($types);
        }

        foreach ($types as $type) {
            $started = microtime(true);

            $this->line(ucfirst($type));

            $this->service->build($type);

            $seconds = microtime(true) - $started;

            $this->info(sprintf('%s seconds', $seconds));
        }

        $this->call('search:speed');
    }

    /**
     * Get the console command arguments.
     *
     *
     */
    protected function getArguments()
    {
        return [
            ['types', InputArgument::IS_ARRAY, []],
        ];
    }
}
