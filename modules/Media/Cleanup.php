<?php

namespace Modules\Media;

use Illuminate\Filesystem\Filesystem;

/**
 * Cleanup the media files that are linked to a resource when the resource
 * itself gets deleted.
 */
class Cleanup
{
    protected $files;

    /**
     * @param Filesystem $files
     * @param Configurator $configurator
     */
    public function __construct(Filesystem $files, Configurator $configurator)
    {
        $this->files = $files;

        $this->configurator = $configurator;
    }

    /**
     * @param $owner
     */
    public function handle($owner)
    {
        if ($owner instanceof StoresMedia) {
            if ($owner->mediaStoresMultiple()) {
                foreach ($owner->images as $image) {
                    $image->delete();
                };
            } elseif ($image = $owner->images) {
                $image->delete();
            }

            $this->files->deleteDirectory($this->configurator->getPublicBasePath($owner));
        }
    }
}
