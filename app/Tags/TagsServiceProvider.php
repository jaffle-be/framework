<?php namespace App\Tags;

use Jaffle\Tools\ServiceProvider;

class TagsServiceProvider extends ServiceProvider{

    protected $namespace = 'tags';

    public function listeners()
    {

    }

    public function observers()
    {
        Tag::observe('App\Tag\TagObserver');
    }

    public function register()
    {

    }

}