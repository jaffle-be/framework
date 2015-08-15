<?php namespace App\Media;

use Jaffle\Tools\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{

    protected $namespace = 'media';

    public function provides()
    {
        return ['path.media'];
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Intervention\Image\ImageManager', 'image');
        $this->app->bind('App\Media\MediaRepositoryInterface', 'App\Media\MediaRepository');
    }

    protected function listeners()
    {
    }

    protected function observers()
    {
        Image::observe('App\Media\ImageObserver');
    }
}