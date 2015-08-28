<?php namespace App\Tags;

use App\Tags\Commands\UntagSomething;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Cleanup
{
    use DispatchesJobs;

    public function handle($owner)
    {
        if($owner instanceof StoresTags)
        {
            foreach($owner->tags as $tag)
            {
                $this->dispatchFromArray(UntagSomething::class, [
                    'owner' => $owner,
                    'tag' => $tag
                ]);
            }
        }
    }

}