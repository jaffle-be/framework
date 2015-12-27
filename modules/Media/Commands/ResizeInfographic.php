<?php

namespace Modules\Media\Commands;

use App\Jobs\Job;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageManager;
use Modules\Media\ImageDimensionHelpers;
use Modules\Media\Infographics\Infographic;
use Modules\Media\MediaRepositoryInterface;

class ResizeInfographic extends Job
{

    use ImageDimensionHelpers;

    protected $graphic;

    protected $size;

    protected $cachedPath;

    protected $filename;

    protected $directory;

    protected $extension;

    public function __construct(Infographic $graphic, $size, $cachedPath = false)
    {
        $this->graphic = $graphic;
        $this->size = $size;
        $this->cachedPath = $cachedPath;

        $this->filename = pathinfo($graphic->path, PATHINFO_BASENAME);
        $this->directory = pathinfo($graphic->path, PATHINFO_DIRNAME);
        $this->extension = pathinfo($graphic->path, PATHINFO_EXTENSION);
    }

    public function handle(MediaRepositoryInterface $media, ImageManager $images, Filesystem $files)
    {
        list($width, $height) = $this->dimensions($this->size);

        $path = $this->getPath($files);

        $constraint = $this->constraint($width, $height);

        $graphic = $images->cache(function ($img) use ($width, $height, $constraint) {

            if ($this->cachedPath) {
                $img = $img->make($this->cachedPath);
            } else {
                $img = $img->make(public_path($this->graphic->path));
            }

            $img->resize($width, $height, $constraint);
        }, 60, true)->save($path);

        if ($graphic) {
            //always fetch the actual width and height from the image,
            //one of them could have been null to auto scale the image.
            $width = $graphic->getWidth();
            $height = $graphic->getHeight();

            //use htmlable public path to store in database
            $path = $this->getPath($files, true);

            try {
                $media->createThumbnailInfographic($this->getPayload($width, $height, $path), $this->graphic);
            } catch (Exception $e) {
                $files->delete(public_path($path));

                unset($graphic);

                return false;
            }

            unset($graphic);
        }
    }

    /**
     * @return string
     */
    protected function getFolder(Filesystem $files, $public = false)
    {
        $base = $this->directory . '/' . $this->size;

        $folder = public_path($base);

        if (!$files->isDirectory($folder)) {
            $files->makeDirectory($folder);
        }

        if ($public) {
            return $base;
        }

        return $folder;
    }

    /**
     * @return string
     */
    protected function getPath(Filesystem $files, $public = false)
    {
        $folder = $this->getFolder($files, $public);

        $path = $folder . '/' . $this->filename;

        return $path;
    }

    /**
     * @return array
     */
    protected function getPayload($width, $height, $path)
    {
        return [
            'filename' => $this->filename,
            'width' => $width,
            'height' => $height,
            'extension' => $this->extension,
            'path' => $path,
        ];
    }
}
