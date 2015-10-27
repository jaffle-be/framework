<?php namespace Modules\Portfolio\Providers;

use Modules\Portfolio\Project;
use Modules\Portfolio\ProjectObserver;
use Pingpong\Modules\ServiceProvider;

class PortfolioServiceProvider extends ServiceProvider
{
    protected $namespace = 'portfolio';

    public function register()
    {
        $this->app->bind('Modules\Portfolio\PortfolioRepositoryInterface', 'Modules\Portfolio\PortfolioRepository');
    }

    protected function listeners()
    {

    }

    protected function observers()
    {
        Project::observe(ProjectObserver::class);
    }
}