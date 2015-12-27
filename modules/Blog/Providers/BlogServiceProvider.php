<?php

namespace Modules\Blog\Providers;

use Modules\Blog\Post;
use Modules\System\ServiceProvider;

/**
 * Class BlogServiceProvider
 * @package Modules\Blog\Providers
 */
class BlogServiceProvider extends ServiceProvider
{
    protected $namespace = 'blog';

    public function register()
    {
        $this->app->bind('Modules\Blog\PostRepositoryInterface', 'Modules\Blog\PostRepository');
    }

    protected function listeners()
    {
        Post::observe('Modules\Blog\PostObserver');
    }
}
