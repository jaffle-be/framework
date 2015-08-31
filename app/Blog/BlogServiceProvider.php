<?php namespace App\Blog;

use App\System\ServiceProvider;

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
        Post::bootPostScopeFront();
        PostTranslation::bootPostTranslationScopeFront();
        Post::observe('App\Blog\PostObserver');
    }
}