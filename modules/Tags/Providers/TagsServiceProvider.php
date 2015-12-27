<?php

namespace Modules\Tags\Providers;

use Modules\System\ServiceProvider;

class TagsServiceProvider extends ServiceProvider
{

    protected $namespace = 'tags';

    public function listeners()
    {
        $this->app['events']->listen('eloquent.deleted: *', 'Modules\Tags\Cleanup');
    }

    public function observers()
    {
    }

    public function register()
    {
    }
}
