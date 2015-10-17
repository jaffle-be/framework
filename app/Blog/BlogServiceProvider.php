<?php namespace App\Blog;

use App\System\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    protected $namespace = 'blog';

    public function register()
    {
        $this->app->bind('App\Blog\PostRepositoryInterface', 'App\Blog\PostRepository');
    }

    protected function listeners()
    {

    }

    protected function observers()
    {
        Post::observe('App\Blog\PostObserver');
    }
}