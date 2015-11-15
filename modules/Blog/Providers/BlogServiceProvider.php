<?php namespace Modules\Blog\Providers;

use Modules\Blog\Post;
use Pingpong\Modules\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{

    protected $namespace = 'blog';

    public function register()
    {
        $this->app->bind('Modules\Blog\PostRepositoryInterface', 'Modules\Blog\PostRepository');
    }

    protected function listeners()
    {
    }

    protected function observers()
    {
        Post::observe('Modules\Blog\PostObserver');
    }
}