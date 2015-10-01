<?php namespace App\Media\Console;

use App\Media\StoresMedia;
use Illuminate\Console\Command;

class RemoveSize extends Command
{
    protected $signature = 'media:remove-size {size} {type=all}';

    public function handle()
    {
        foreach($this->getTypes() as $type)
        {
            $entity = app($type);

            $entity->chunk(250, function($owners){

                list($width, $height) = explode('x', $this->argument('size'), 2);

                $owners->load(['images', 'images.sizes' => function($query) use ($width, $height){
                    $query->dimension($width, $height);
                }]);

                foreach($owners as $owner)
                {
                    /* @var StoresMedia $owner */
                    $this->handleOwner($owner);
                }
            });
        }
    }

    /**
     * @param $owner
     */
    function handleImage($image)
    {
        foreach ($image->sizes as $size) {
            $size->delete();
        }
    }

    /**
     * @param $owner
     * @param $this
     */
    function handleOwner($owner)
    {
        if ($owner->mediaStoresMultiple()) {
            foreach ($owner->images as $image) {
                $this->handleImage($image);
            }
        } else if ($owner->images) {
            $this->handleImage($owner->images);
        }
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

}