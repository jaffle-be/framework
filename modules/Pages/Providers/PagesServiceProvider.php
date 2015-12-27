<?php

namespace Modules\Pages\Providers;

use Modules\System\ServiceProvider;

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
