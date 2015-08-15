<?php namespace App\Media;

use Illuminate\Filesystem\Filesystem;

/**
 * Class ImageObserver
 *
 * @package Media
 */
class ImageObserver {

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * @param Image $image
     */
    public function deleting(Image $image)
    {
        $image->translations()->delete();

        foreach($image->sizes as $size)
        {
            $size->delete();
        }
    }

    /**
     * @param Image $image
     */
    public function deleted(Image $image)
    {
        $this->files->delete($image->path);
    }

}