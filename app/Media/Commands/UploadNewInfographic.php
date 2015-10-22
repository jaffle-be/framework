<?php namespace App\Media\Commands;

use App\Account\AccountManager;
use App\Jobs\Job;
use App\Media\StoresMedia;
use App\System\Locale;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadNewInfographic extends Job implements SelfHandling
{

    use DispatchesCommands;

    /**
     * @var StoresMedia
     */
    protected $owner;

    /**
     * @var UploadedFile
     */
    protected $graphic;

    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @param StoresMedia  $owner
     * @param UploadedFile $image
     * @param Locale       $locale
     */
    public function __construct(StoresMedia $owner, UploadedFile $graphic, Locale $locale)
    {
        $this->owner = $owner;
        $this->graphic = $graphic;
        $this->locale = $locale;
    }

    public function handle(Filesystem $files, AccountManager $manager)
    {
        $temp_dir = storage_path('media') . '/' . $this->owner->getMediaFolder('infographics');

        $name = $this->uniqueName();

        $this->graphic->move($temp_dir, $name);

        $temp_file = $temp_dir . $name;

        $name_with_extension = $name . $this->extension($temp_file);

        $final_path = $temp_file . $name_with_extension;

        $files->move($temp_file, $final_path);

        $image = $this->dispatchFromArray(StoreNewInfographic::class, [
            'account' => $manager->account(),
            'owner' => $this->owner,
            'path'  => $final_path,
            'locale' => $this->locale
        ]);

        $files->delete($final_path);

        return $image;
    }

    protected function uniqueName()
    {
        return sha1(md5($this->graphic->getClientOriginalName()) . time());
    }

    private function extension($path)
    {
        $info = getimagesize($path);

        return image_type_to_extension($info[2]);
    }

}