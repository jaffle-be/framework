<?php

namespace Modules\Media\Commands;

use App\Jobs\Job;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\AccountManager;
use Modules\Media\StoresMedia;
use Modules\System\Locale;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadNewFile extends Job
{
    use DispatchesJobs;

    /**
     * @var StoresMedia
     */
    protected $owner;

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @internal param UploadedFile $image
     */
    public function __construct(StoresMedia $owner, UploadedFile $file, Locale $locale)
    {
        $this->owner = $owner;
        $this->file = $file;
        $this->locale = $locale;
    }

    public function handle(Filesystem $files, AccountManager $manager)
    {
        $temp_dir = storage_path('media').'/'.$this->owner->getMediaFolder('files');

        $name = $this->uniqueName();

        $this->file->move($temp_dir, $name);

        $temp_file = $temp_dir.$name;

        $name_with_extension = $name.$this->extension($temp_file);

        $final_path = $temp_dir.$name_with_extension;

        $files->move($temp_file, $final_path);

        $this->dispatch(new StoreNewFile($manager->account(), $this->owner, $final_path, $this->locale));

        $files->delete($final_path);

        return $image;
    }

    /**
     * For files, we won't generate a very random name,
     * so we can easily.
     *
     * @return mixed|null|string
     */
    protected function uniqueName()
    {
        $filename = $this->file->getClientOriginalName();

        $filename = str_replace(' ', '-', $filename);

        $pieces = explode('.', $filename);

        array_pop($pieces);

        return implode('.', $pieces);
    }

    private function extension($path)
    {
        $info = getimagesize($path);

        return image_type_to_extension($info[2]);
    }
}
