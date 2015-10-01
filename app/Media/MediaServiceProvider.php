<?php namespace App\Media;

use App\System\ServiceProvider;

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

        $this->commands(['App\Media\Console\Rebatch', 'App\Media\Console\RemoveSize']);
    }

    protected function listeners()
    {
        $this->app['events']->listen('eloquent.deleted: *', 'App\Media\Cleanup');
    }

    protected function observers()
    {
        Image::observe('App\Media\ImageObserver');
    }
}