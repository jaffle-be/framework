<?php namespace App\Media\Commands;

use App\Jobs\Job;
use App\Media\Media;
use App\Media\MediaRepositoryInterface;
use App\Media\StoresMedia;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Intervention\Image\ImageManager;

class StoreNewImage extends Job implements SelfHandling
{

    use DispatchesCommands;

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
     * @var array
     */
    protected $sizes;

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
     * @var
     */
    protected $prefix;

    /**
     * @var
     */
    protected $seeding;

    /**
     * @param string $currentPath
     * @param array  $sizes
     */
    public function __construct(StoresMedia $owner, $path, $rename = null, array $sizes = [], $seeding = false)
    {
        $this->owner = $owner;
        $this->currentPath = $path;
        $this->directory = pathinfo($path, PATHINFO_DIRNAME);
        $this->filename = pathinfo($path, PATHINFO_FILENAME);
        $this->extension = pathinfo($path, PATHINFO_EXTENSION);
        $this->basename = pathinfo($this->currentPath, PATHINFO_BASENAME);
        $this->rename = $rename;
        $this->sizes = $sizes;
        $this->seeding = $seeding;
    }

    public function handle(MediaRepositoryInterface $repo, ImageManager $images, Filesystem $files, Repository $config)
    {
        if (!$files->exists($this->currentPath)) {
            return false;
        }

        $this->prepare($images, $files, $config);

        $image = $repo->createImage($this->getPayload());

        if ($image) {
            $this->owner->images()->save($image);

            $this->owner->save();

            foreach ($this->sizes as $size) {
                $this->dispatchFromArray(ResizeImage::class, [
                    'image' => $image,
                    'size'  => $size,
                    'cachedPath' => $this->currentPath,
                ]);
            }

            return $image;
        }

        return false;
    }

    /**
     * set the filename, extension and the size
     */
    protected function dimensions(ImageManager $image)
    {
        $this->width = $image->make($this->currentPath)->width();
        $this->height = $image->make($this->currentPath)->height();
    }

    protected function handleFile(Filesystem $files, Repository $config)
    {
        $subFolder = $config->get('media.path') . '/' . $this->prefix;

        if (!$files->isDirectory(public_path($subFolder))) {
            $files->makeDirectory(public_path($subFolder), 0755, true);
        }

        $path = $subFolder . $this->rename;

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
     * @return array
     */
    protected function getPayload()
    {
        return [
            'path'      => $this->path,
            'filename'  => $this->rename,
            'extension' => $this->extension,
            'width'     => $this->width,
            'height'    => $this->height,
        ];
    }

    /**
     * @param ImageManager $images
     * @param Filesystem   $files
     * @param Repository   $config
     */
    protected function prepare(ImageManager $images, Filesystem $files, Repository $config)
    {
        $this->dimensions($images);
        $this->newName();
        $this->prefix();
        $this->handleFile($files, $config);
    }

    protected function prefix()
    {
        $this->prefix = $this->owner->getMediaFolder();
    }
}