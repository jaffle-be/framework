<?php

namespace Modules\Media\Commands;

use App\Jobs\Job;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Intervention\Image\ImageManager;
use Modules\Account\Account;
use Modules\Media\Configurator;
use Modules\Media\MediaRepositoryInterface;
use Modules\Media\StoresMedia;

/**
 * Class StoreNewImage
 * @package Modules\Media\Commands
 */
class StoreNewImage extends Job
{
    use DispatchesJobs;

    protected $account;

    /**
     * @var StoresMedia
     */
    protected $owner;

    /**
     * @var string
     */
    protected $currentPath;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var null|string
     */
    protected $rename;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var string
     */
    protected $path;

    /**
     * $sizes
     * @param Account $account
     * @param StoresMedia $owner
     * @param $path
     * @param null $rename
     */
    public function __construct(Account $account = null, StoresMedia $owner, $path, $rename = null)
    {
        $this->account = $account;
        $this->owner = $owner;
        $this->currentPath = $path;
        $this->directory = pathinfo($path, PATHINFO_DIRNAME);
        $this->filename = pathinfo($path, PATHINFO_FILENAME);
        $this->extension = pathinfo($path, PATHINFO_EXTENSION);
        $this->basename = pathinfo($this->currentPath, PATHINFO_BASENAME);
        $this->rename = $rename;
    }

    /**
     * @param MediaRepositoryInterface $repo
     * @param ImageManager $images
     * @param Filesystem $files
     * @param Configurator $config
     * @return bool
     */
    public function handle(MediaRepositoryInterface $repo, ImageManager $images, Filesystem $files, Configurator $config)
    {
        if (! $files->exists($this->currentPath)) {
            return false;
        }

        $this->dimensions($images);
        $this->newName();
        $this->handleFile($files, $config);

        try {
            $image = $repo->createImage($this->owner, $this->getPayload());
        } catch (Exception $e) {
            $files->delete(public_path($this->path));

            return false;
        }

        if ($image) {
            foreach ($config->getImageSizes($this->owner) as $size) {
                $this->dispatch(new ResizeImage($image, $size, $this->currentPath));
            }

            return $image;
        }

        return false;
    }

    /**
     * set the filename, extension and the size.
     * @param ImageManager $image
     */
    protected function dimensions(ImageManager $image)
    {
        $resource = $image->make($this->currentPath);
        $this->width = $resource->width();
        $this->height = $resource->height();
        unset($resource);
    }

    /**
     * @param Filesystem $files
     * @param Configurator $config
     */
    protected function handleFile(Filesystem $files, Configurator $config)
    {
        $abstract = $config->getAbstractPath($this->owner, 'images');
        $public = $config->getPublicPath($this->owner, 'images');

        if (! $files->isDirectory($public)) {
            $files->makeDirectory($public, 0755, true);
        }

        //abstract path to actual file
        $path = $abstract.$this->rename;

        //always copy the file first
        $files->copy($this->currentPath, public_path($path));

        $this->path = $path;
    }

    protected function newName()
    {
        if (empty($this->rename)) {
            $this->rename = $this->basename;
        }
    }

    /**
     *
     */
    protected function getPayload()
    {
        return [
            'account_id' => $this->account ? $this->account->id : null,
            'path' => $this->path,
            'filename' => $this->rename,
            'extension' => $this->extension,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
