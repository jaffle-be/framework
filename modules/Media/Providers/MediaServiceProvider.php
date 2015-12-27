<?php namespace Modules\Media\Providers;

use Modules\Media\Files\File;
use Modules\Media\Image;
use Modules\Media\Infographics\Infographic;
use Modules\System\ServiceProvider;

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
        $this->app->bind('Modules\Media\MediaRepositoryInterface', 'Modules\Media\MediaRepository');

        $this->app->singleton('Modules\Media\Configurator');

        $this->commands(['Modules\Media\Console\Rebatch', 'Modules\Media\Console\RemoveSize']);
    }

    protected function listeners()
    {
        $this->app['events']->listen('eloquent.deleted: *', 'Modules\Media\Cleanup');

        $this->observers();
    }

    protected function observers()
    {
        Image::observe('Modules\Media\ImageObserver');
        Infographic::observe('Modules\Media\Infographics\InfographicObserver');
        File::observe('Modules\Media\Files\FileObserver');
    }
}