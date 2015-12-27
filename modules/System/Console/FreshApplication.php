<?php

namespace Modules\System\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class FreshApplication extends Command
{
    protected $signature = 'system:fresh {--seed}';

    protected $description = 'test';

    /**
     * @var Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $this->files->deleteDirectory(public_path(config('media.path')));

        $this->call('migrate:refresh');
        $this->call('cache:clear');
        $this->call('search:speed', ['speed' => '5m']);
        $this->call('search:flush');
        $this->call('search:settings');
        $this->call('search:build');

        if ($this->option('seed')) {
            $this->call('db:seed');
        }

        $this->call('search:speed');
    }
}
