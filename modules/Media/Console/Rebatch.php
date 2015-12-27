<?php

namespace Modules\Media\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Media\Commands\ResizeImage;
use Modules\Media\Configurator;
use Modules\Media\Image;
use Modules\Media\StoresMedia;

class Rebatch extends Command
{
    use DispatchesJobs;

    protected $signature = 'media:rebatch {type=all} {--sizes=all} {--force}';

    protected $files;

    public function __construct(Configurator $config, Filesystem $files)
    {
        $this->config = $config;

        $this->files = $files;

        parent::__construct();
    }

    public function handle()
    {
        $force = $this->option('force');

        //get the types to rebatch.
        $types = $this->config->getTypes($this->argument('type'));

        $sizes = $this->option('sizes');

        foreach ($types as $type) {
            $entity = app($type);

            $this->handleType($entity, $this->sizesForType($type, $sizes), $force);
        }
    }

    protected function sizesForType($type, $requested)
    {
        if (class_exists($type)) {
            return $this->config->getImageSizes(new $type(), $requested);
        }

        return $this->config->getImageSizes(new $this->config->classname($type), $requested);
    }

    /**
     *
     *
     *
     */
    protected function handleType(StoresMedia $type, array $sizes, $force)
    {
        //if(forcing a rebatch) then delete all thumbs for the requested sizes here.
        //this will avoid alot of extra work down the road. we'd be calling this command for every image if not.
        if ($force) {
            foreach ($sizes as $size) {
                $this->call('media:remove-size', [
                    'size' => $size,
                    'type' => $this->config->alias($type),
                ]);
            }
        }

        $type->chunk(250, function ($owners) use ($sizes, $force) {
            $owners->load(['images', 'images.sizes']);

            foreach ($owners as $owner) {
                $this->handleOwner($owner, $sizes, $force);
            }
        });
    }

    /**
     *
     *
     *
     */
    protected function handleOwner(StoresMedia $owner, array $sizes, $force)
    {
        if ($owner->mediaStoresMultiple()) {
            //check which sizes aren't there.
            //only resize those.
            foreach ($owner->images as $image) {
                $this->handleImage($sizes, $image, $force);
            }
        } elseif ($owner->images) {
            $this->handleImage($sizes, $owner->images, $force);
        }
    }

    /**
     *
     *
     *
     */
    protected function handleImage(array $sizes, Image $image, $force)
    {
        if ($force) {
            $resizes = $sizes;
        } else {
            $resizes = $this->sizesToResize($image, $sizes);
        }

        foreach ($resizes as $resize) {
            $job = new ResizeImage($image, $resize);

            $this->dispatch($job);
        }
    }

    protected function sizesToResize(Image $image, $sizes)
    {
        $resizing = [];

        foreach ($sizes as $size) {
            $path = $image->path;

            $info = pathinfo($path);

            $path = $info['dirname'].'/'.$size.'/'.$info['basename'];

            if (!$this->imageHasSize($image, $path)) {
                $resizing[] = $size;
            }
        }

        return $resizing;
    }

    /**
     *
     *
     *
     * @return mixed
     */
    protected function imageHasSize(Image $image, $path)
    {
        return $image->sizes->filter(function ($item) use ($path) {
            return $item->path == $path && file_exists(public_path($path));
        })->first();
    }
}
