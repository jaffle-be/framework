<?php namespace App\Media\Commands;

use App\Account\AccountManager;
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
     * @param StoresMedia  $owner
     * @param UploadedFile $image
     */
    public function __construct(StoresMedia $owner, UploadedFile $image)
    {
        $this->owner = $owner;
        $this->image = $image;
    }

    public function handle(Filesystem $files, AccountManager $manager)
    {
        $temp_dir = storage_path('media') . '/' . $this->owner->getMediaFolder();

        $name = $this->uniqueName();

        $this->image->move($temp_dir, $name);

        $temp_file = $temp_dir . $name;

        $name_with_extension = $name . $this->extension($temp_file);

        $final_path = $temp_file . $name_with_extension;

        $files->move($temp_file, $final_path);

        $image = $this->dispatchFromArray(StoreNewImage::class, [
            'account' => $manager->account(),
            'owner' => $this->owner,
            'path'  => $final_path,
        ]);

        $files->delete($final_path);

        return $image;
    }

    protected function uniqueName()
    {
        return sha1(md5($this->image->getClientOriginalName()) . time());
    }

    private function extension($path)
    {
        $info = getimagesize($path);

        return image_type_to_extension($info[2]);
    }

}