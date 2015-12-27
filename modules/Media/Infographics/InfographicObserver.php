<?php

namespace Modules\Media\Infographics;

use Illuminate\Filesystem\Filesystem;

/**
 * Class InfographicObserver.
 */
class InfographicObserver
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     *
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     *
     */
    public function deleting(Infographic $graphic)
    {
        //only try deleting thumbnails when we are no thumbnail
        if ($graphic->original_id === null) {
            foreach ($graphic->sizes as $size) {
                $size->delete();
            }
        }
    }

    /**
     *
     */
    public function deleted(Infographic $graphic)
    {
        $this->files->delete(public_path($graphic->path));
    }
}
