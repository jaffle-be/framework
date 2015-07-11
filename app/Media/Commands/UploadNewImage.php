<?php namespace App\Media\Commands;

use App\Jobs\Job;
use App\Media\StoresMedia;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadNewImage extends Job implements SelfHandling
{

    use DispatchesCommands;

    /**
     * @var StoresMedia
     */
    protected $owner;

    /**
     * @var UploadedFile
     */
    protected $image;

    /**
     * @var array
     */
    protected $sizes;

    /**
     * @param StoresMedia  $owner
     * @param UploadedFile $image
     * @param array        $sizes
     */
    public function __construct(StoresMedia $owner, UploadedFile $image, array $sizes)
    {
        $this->owner = $owner;
        $this->image = $image;
        $this->sizes = $sizes;
    }

    public function handle(Filesystem $files)
    {
        $temp_dir = app_path('storage') . '/' . $this->owner->getMediaFolder();

        $temp_path = $temp_dir . '/' . $this->image->getClientOriginalName();

        $this->image->move($temp_dir, $this->image->getClientOriginalName());

        $image = $this->dispatchFromArray(StoreNewImage::class, [
            'owner' => $this->owner,
            'path'  => $temp_path,
            'sizes' => $this->sizes
        ]);

        $files->delete($temp_path);

        return $image;
    }

}