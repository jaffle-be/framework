<?php namespace Modules\Media;

use Illuminate\Filesystem\Filesystem;

/**
 * Class ImageObserver
 *
 * @package Media
 */
class ImageObserver
{

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
        //only try deleting translations and thumbnails when we are no thumbnail
        if ($image->original_id === null) {
            $image->translations()->delete();

            foreach ($image->sizes as $size) {
                $size->delete();
            }
        }
    }

    /**
     * @param Image $image
     */
    public function deleted(Image $image)
    {
        $this->files->delete(public_path($image->path));
    }

}