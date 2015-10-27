<?php namespace Modules\Tags\Providers;

use Modules\Tags\Tag;
use Pingpong\Modules\ServiceProvider;

class TagsServiceProvider extends ServiceProvider{

    protected $namespace = 'tags';

    public function listeners()
    {
        $this->app['events']->listen('eloquent.deleted: *', 'Modules\Tags\Cleanup');
    }

    public function observers()
    {
        Tag::observe('Modules\Tags\TagObserver');
    }

    public function register()
    {

    }

}