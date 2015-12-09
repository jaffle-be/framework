<?php namespace Modules\Pages\Providers;

use Pingpong\Modules\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{

    protected $namespace = 'pages';

    public function register()
    {
        $this->app->singleton('Modules\Pages\PageRepositoryInterface', 'Modules\Pages\PageRepository');
    }

    protected function listeners()
    {
    }

}