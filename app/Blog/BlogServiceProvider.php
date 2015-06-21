<?php namespace App\Blog;

use Jaffle\Tools\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    protected $namespace = 'blog';

    public function register()
    {

    }

    protected function listeners()
    {

    }

    protected function observers()
    {
        Post::observe('App\Blog\PostObserver');
        PostTranslation::observe('App\Blog\PostTranslationObserver');
    }
}