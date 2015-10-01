<?php namespace App\Media\Console;

use App\Media\Commands\ResizeImage;
use App\Media\Image;
use App\Media\StoresMedia;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Rebatch extends Command
{

    use DispatchesJobs;

    protected $signature = 'media:rebatch {type=all} {--sizes=all} {--force}';

    public function handle()
    {
        $force = $this->option('force');

        $types = $this->getTypes();

        foreach ($types as $type) {

            $entity = app($type);

            $sizes = $this->sizesForType($type);

            $this->handleType($entity, $sizes, $force);
        }
    }

    protected function sizesForType($type)
    {
        $sizes = config('media.sizes');

        $owners = config('media.owners');

        $index = array_search($type, $owners);

        if ($index === false) {
            return [];
        }

        $requested = $this->option('sizes');

        if($requested == 'all')
        {
            return $sizes[$index];
        }

        //the option passed can be , separated list of aliases
        //explode them and make sure to use the actual class instead of the alias
        $requested = explode(',', $requested);

        return array_intersect($sizes[$index], $requested);
    }

    protected function getTypes()
    {
        $type = $this->argument('type');

        if ($type == 'all') {
            //use all defined owners
            return array_values(config('media.owners'));
        }

        //make sure the type provided is a known type.
        //type argument in console should be passed by its alias defined in the owners config.
        return array_values(array_intersect_key(config('media.owners'), array_flip([$type])));
    }

    /**
     * @param StoresMedia $type
     * @param array       $sizes
     * @param bool        $force
     */
    protected function handleType(StoresMedia $type, array $sizes, $force)
    {
        $type->chunk(250, function ($owners) use ($sizes, $force) {
            $owners->load(['images', 'images.sizes']);

            foreach ($owners as $owner) {
                $this->handleOwner($owner, $sizes, $force);
            }
        });
    }

    /**
     * @param StoresMedia $owner
     * @param array       $sizes
     * @param bool        $force
     */
    protected function handleOwner(StoresMedia $owner, array $sizes, $force)
    {
        if ($owner->mediaStoresMultiple()) {

            //check which sizes aren't there.
            //only resize those.
            foreach ($owner->images as $image) {

                $this->handleImage($sizes, $image, $force);
            }
        } else if ($owner->images) {
            $this->handleImage($sizes, $owner->images, $force);
        }
    }

    /**
     * @param array $sizes
     * @param Image $image
     * @param bool  $force
     */
    protected function handleImage(array $sizes, Image $image, $force)
    {
        if($force)
        {
            $resizes = $sizes;
        }
        else{
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

            $path = $info['dirname'] . DIRECTORY_SEPARATOR . $size . DIRECTORY_SEPARATOR . $info['basename'];

            if (!$this->imageHasSize($image, $path)) {
                $resizing[] = $size;
            }
        }

        return $resizing;
    }

    /**
     * @param Image $image
     * @param       $path
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