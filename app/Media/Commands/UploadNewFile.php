<?php namespace App\Media\Commands;

use App\Account\AccountManager;
use App\Jobs\Job;
use App\Media\StoresMedia;
use App\System\Locale;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadNewFile extends Job implements SelfHandling
{

    use DispatchesCommands;

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
     * @param StoresMedia  $owner
     * @param UploadedFile $image
     * @param Locale       $locale
     */
    public function __construct(StoresMedia $owner, UploadedFile $file, Locale $locale)
    {
        $this->owner = $owner;
        $this->file = $file;
        $this->locale = $locale;
    }

    public function handle(Filesystem $files, AccountManager $manager)
    {
        $temp_dir = storage_path('media') . '/' . $this->owner->getMediaFolder();

        $name = $this->uniqueName();

        $this->file->move($temp_dir, $name);

        $temp_file = $temp_dir . $name;


        $name_with_extension = $name . $this->extension($temp_file);

        $final_path = $temp_dir . $name_with_extension;

        $files->move($temp_file, $final_path);

        $image = $this->dispatchFromArray(StoreNewFile::class, [
            'account' => $manager->account(),
            'owner' => $this->owner,
            'path'  => $final_path,
            'locale' => $this->locale
        ]);

        $files->delete($final_path);

        return $image;
    }

    /**
     * For files, we won't generate a very random name,
     * so we can easily
     *
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