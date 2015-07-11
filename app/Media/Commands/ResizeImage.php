<?php namespace App\Media\Commands;

use App\Jobs\Job;
use App\Media\Image;
use App\Media\MediaRepositoryInterface;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageManager;

class ResizeImage extends Job implements SelfHandling
{

    protected $image;

    protected $size;

    protected $cachedPath;

    protected $filename;

    protected $directory;

    protected $extension;

    public function __construct(Image $image, $size, $cachedPath = false)
    {
        $this->image = $image;
        $this->size = $size;
        $this->cachedPath = $cachedPath;

        $this->filename = pathinfo($image->path, PATHINFO_BASENAME);
        $this->directory = pathinfo($image->path, PATHINFO_DIRNAME);
        $this->extension = pathinfo($image->path, PATHINFO_EXTENSION);
    }

    public function handle(MediaRepositoryInterface $media, ImageManager $images, Filesystem $files)
    {
        list($width, $height) = $this->dimensions();

        $path = $this->getPath($files);

        $constraint = $this->constraint($width, $height);

        $image = $images->cache(function($image) use ($width, $height, $constraint){

            if($this->cachedPath)
            {
                $image = $image->make($this->cachedPath);
            }
            else{
                $image = $image->make(public_path($this->image->path));
            }

            $image->resize($width, $height, $constraint);
        }, 5, true)->save($path);

        //always fetch the actual height from the image,
        //it could have been null to auto scale the image.
        $height = $image->getHeight();

        if ($image) {
            //use html public path to store in database
            $path = $this->getPath($files, true);

            $media->createImage($this->getPayload($width, $height, $path), $this->image);
        }
    }

    /**
     * @param Filesystem $files
     *
     * @param bool       $public
     *
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
     * @param Filesystem $files
     *
     * @return string
     */
    protected function getPath(Filesystem $files, $public = false)
    {
        $folder = $this->getFolder($files, $public);

        $path = $folder . '/' . $this->filename;

        return $path;
    }

    /**
     * @param $width
     * @param $height
     * @param $path
     *
     * @return array
     */
    protected function getPayload($width, $height, $path)
    {
        return [
            'filename'  => $this->filename,
            'width'     => $width,
            'height'    => $height,
            'extension' => $this->extension,
            'path'      => $path,
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function dimensions()
    {
        if (strpos($this->size, 'x') === false && is_numeric($this->size)) {
            return array($this->size, null);
        }

        list($width, $height) = explode('x', $this->size);

        if (!is_numeric($width) || !is_numeric($height)) {
            throw new Exception('Invalid image size provided');
        }

        return array($width, $height);
    }

    protected function constraint($width, $height)
    {
        if($width === null || $height === null)
        {
            return function($constraint){
                $constraint->aspectRatio();
            };
        }

        return null;
    }
}