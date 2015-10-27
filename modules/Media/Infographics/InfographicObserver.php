<?php namespace Modules\Media\Infographics;

use Illuminate\Filesystem\Filesystem;

/**
 * Class InfographicObserver
 *
 * @package Media
 */
class InfographicObserver {

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
     * @param Infographic $graphic
     */
    public function deleting(Infographic $graphic)
    {
        //only try deleting thumbnails when we are no thumbnail
        if($graphic->original_id === null)
        {
            foreach($graphic->sizes as $size)
            {
                $size->delete();
            }
        }
    }

    /**
     * @param Infographic $graphic
     */
    public function deleted(Infographic $graphic)
    {
        $this->files->delete(public_path($graphic->path));
    }

}