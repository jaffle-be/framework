<?php

namespace Modules\Media\Commands;

use App\Jobs\Job;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\AccountManager;
use Modules\Media\StoresMedia;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploadNewImage
 * @package Modules\Media\Commands
 */
class UploadNewImage extends Job
{
    use DispatchesJobs;

    /**
     * @var StoresMedia
     */
    protected $owner;

    /**
     * @var UploadedFile
     */
    protected $image;

    /**
     * @param StoresMedia $owner
     * @param UploadedFile $image
     */
    public function __construct(StoresMedia $owner, UploadedFile $image)
    {
        $this->owner = $owner;
        $this->image = $image;
    }

    /**
     * @param Filesystem $files
     * @param AccountManager $manager
     * @return mixed
     */
    public function handle(Filesystem $files, AccountManager $manager)
    {
        $temp_dir = storage_path('media').'/'.$this->owner->getMediaFolder('images');

        $name = $this->uniqueName();

        $this->image->move($temp_dir, $name);

        $temp_file = $temp_dir.$name;

        $name_with_extension = $name.$this->extension($temp_file);

        $final_path = $temp_file.$name_with_extension;

        $files->move($temp_file, $final_path);

        $image = $this->dispatch(new StoreNewImage($manager->account(), $this->owner, $final_path));

        $files->delete($final_path);

        return $image;
    }

    /**
     * @return string
     */
    protected function uniqueName()
    {
        return sha1(md5($this->image->getClientOriginalName()).time());
    }

    /**
     * @param $path
     * @return string
     */
    private function extension($path)
    {
        $info = getimagesize($path);

        return image_type_to_extension($info[2]);
    }
}
