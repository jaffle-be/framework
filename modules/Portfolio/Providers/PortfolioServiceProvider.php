<?php namespace Modules\Portfolio\Providers;

use Modules\Portfolio\Project;
use Modules\Portfolio\ProjectObserver;
use Modules\System\ServiceProvider;

class PortfolioServiceProvider extends ServiceProvider
{

    protected $namespace = 'portfolio';

    public function register()
    {
        $this->app->bind('Modules\Portfolio\PortfolioRepositoryInterface', 'Modules\Portfolio\PortfolioRepository');
    }

    protected function listeners()
    {
    	Project::observe(ProjectObserver::class);
    }
}