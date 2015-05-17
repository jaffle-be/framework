<?php namespace App\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //include our routes
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'blog');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'blog');
        $this->mergeConfigFrom(__DIR__ . '/config/blog.php', 'blog');

        //event listeners
        $this->listeners();
    }

    public function register()
    {
    }

    protected function listeners()
    {

    }
}