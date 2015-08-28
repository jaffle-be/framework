<?php namespace App\Media;

use Illuminate\Filesystem\Filesystem;

class Cleanup
{

    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function handle($owner)
    {
        if($owner instanceof StoresMedia)
        {

            if($owner->mediaStoresMultiple())
            {
                foreach($owner->images as $image)
                {
                    $image->delete();
                };

            }
            elseif ($image = $owner->images)
            {
                $image->delete();
            }

            $this->files->deleteDirectory(public_path(config('media.path') . '/' . $owner->getMediaFolder()));
        }
    }

}