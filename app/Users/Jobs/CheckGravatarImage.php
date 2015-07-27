<?php namespace App\Users\Jobs;

use App\Jobs\Job;
use App\Media\Commands\StoreNewImage;
use App\Users\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
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

    public function handle(Gravatar $gravatar, Filesystem $files)
    {
        if($gravatar->exists($this->user->email))
        {
            $gravatar->setAvatarSize(512);

            $url = $gravatar->get($this->user->email);

            $content = file_get_contents($url);

            if(!$files->isDirectory(storage_path('tmp')))
            {
                $files->makeDirectory(storage_path('tmp'));
            }

            $path = storage_path('tmp/' . sha1(time() . 'user-profile-pic' . $this->user->id));

            $files->put($path, $content);

            $this->dispatch(new StoreNewImage($this->user, $path, null, config('media.sizes.user')));
        }

    }


}