<?php namespace App\Portfolio;

use App\System\ServiceProvider;

class PortfolioServiceProvider extends ServiceProvider
{
    protected $namespace = 'portfolio';

    public function register()
    {

    }

    protected function listeners()
    {

    }

    protected function observers()
    {
        Project::observe(ProjectObserver::class);
        Project::bootProjectScopeFront();
    }
}