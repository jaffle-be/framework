<?php

namespace Modules\Media\Files;

use Illuminate\Filesystem\Filesystem;

/**
 * Class FileObserver.
 */
class FileObserver
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
    public function deleted(File $file)
    {
        $this->files->delete(public_path($file->path));
    }
}
