<?php

namespace Modules\Media\Commands;

use App\Jobs\Job;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\AccountManager;
use Modules\Media\StoresMedia;
use Modules\System\Locale;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadNewInfographic extends Job
{
    use DispatchesJobs;

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
     * $image
     */
    public function __construct(StoresMedia $owner, UploadedFile $graphic, Locale $locale)
    {
        $this->owner = $owner;
        $this->graphic = $graphic;
        $this->locale = $locale;
    }

    public function handle(Filesystem $files, AccountManager $manager)
    {
        $temp_dir = storage_path('media').'/'.$this->owner->getMediaFolder('infographics');

        $name = $this->uniqueName();

        $this->graphic->move($temp_dir, $name);

        $temp_file = $temp_dir.$name;

        $name_with_extension = $name.$this->extension($temp_file);

        $final_path = $temp_file.$name_with_extension;

        $files->move($temp_file, $final_path);

        $image = $this->dispatch(new StoreNewInfographic($manager->account(), $this->owner, $this->locale, $final_path));

        $files->delete($final_path);

        return $image;
    }

    protected function uniqueName()
    {
        return sha1(md5($this->graphic->getClientOriginalName()).time());
    }

    private function extension($path)
    {
        $info = getimagesize($path);

        return image_type_to_extension($info[2]);
    }
}
