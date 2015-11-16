<?php namespace Modules\Users\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\AccountManager;
use Modules\Media\Commands\StoreNewImage;
use Modules\Users\User;
use Thomaswelton\LaravelGravatar\Gravatar;

class CheckGravatarImage extends Job implements SelfHandling
{

    use DispatchesJobs;

    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(Gravatar $gravatar, Filesystem $files, AccountManager $manager)
    {
        if ($gravatar->exists($this->user->email)) {
            $gravatar->setAvatarSize(512);

            $url = $gravatar->get($this->user->email);

            $content = file_get_contents($url);

            $tmpDir = storage_path('media' . '/' . $this->user->getMediaFolder());

            if (!$files->isDirectory($tmpDir)) {
                $files->makeDirectory($tmpDir, 0755, true);
            }

            $path = $tmpDir . sha1(time() . 'user-profile-pic' . $this->user->id);

            $files->put($path, $content);

            $finalPath = $this->pathWithExtension($path);

            $files->move($path, $finalPath);

            $this->dispatch(new StoreNewImage($manager->account(), $this->user, $finalPath));

            $files->delete($finalPath);
        }
    }

    /**
     * @param $path
     *
     * @return string
     */
    protected function pathWithExtension($path)
    {
        $info = getimagesize($path);

        //add the extension based on the image type
        $finalPath = $path . image_type_to_extension($info[2]);

        return $finalPath;
    }

}