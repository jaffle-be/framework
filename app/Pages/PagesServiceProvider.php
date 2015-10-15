<?php namespace App\Pages;

use App\System\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    protected $namespace = 'pages';

    public function register()
    {
        $this->app->singleton('App\Pages\PageRepositoryInterface', 'App\Pages\PageRepository');
    }

    protected function listeners()
    {

    }

    protected function observers()
    {

    }
}