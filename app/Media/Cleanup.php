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
            foreach($owner->images as $image)
            {
                $image->delete();
            };

            $this->files->deleteDirectory(public_path(config('media.path') . '/' . $owner->getMediaFolder()));
        }
    }

}