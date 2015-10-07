<?php namespace App\Media\Commands;

use App\Account\Account;
use App\Jobs\Job;
use App\Media\Configurator;
use App\Media\Media;
use App\Media\MediaRepositoryInterface;
use App\Media\StoresMedia;
use Illuminate\Contracts\Bus\SelfHandling;
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
    protected $seeding;

    /**
     * @param Account     $account
     * @param StoresMedia $owner
     * @param string      $path
     * @param null        $rename
     * @param array       $sizes
     * @param bool        $seeding
     */
    public function __construct(Account $account, StoresMedia $owner, $path, $rename = null, array $sizes = [], $seeding = false)
    {
        $this->account = $account;
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

    public function handle(MediaRepositoryInterface $repo, ImageManager $images, Filesystem $files, Configurator $config)
    {
        if (!$files->exists($this->currentPath)) {
            return false;
        }

        $this->dimensions($images);
        $this->newName();
        $this->handleFile($files, $config);

        $image = $repo->createImage($this->owner, $this->getPayload());

        if ($image) {

            foreach ($this->sizes as $size) {
                $this->dispatchFromArray(ResizeImage::class, [
                    'image'      => $image,
                    'size'       => $size,
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
        $resource = $image->make($this->currentPath);
        $this->width = $resource->width();
        $this->height = $resource->height();
    }

    protected function handleFile(Filesystem $files, Configurator $config)
    {
        $abstract = $config->getAbstractPath($this->owner);
        $public = $config->getPublicPath($this->owner);

        if (!$files->isDirectory($public)) {
            $files->makeDirectory($public, 0755, true);
        }

        //abstract path to actual file
        $path = $abstract . $this->rename;

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
            'account_id' => $this->account->id,
            'path'       => $this->path,
            'filename'   => $this->rename,
            'extension'  => $this->extension,
            'width'      => $this->width,
            'height'     => $this->height,
        ];
    }
}