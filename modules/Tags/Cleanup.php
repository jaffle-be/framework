<?php

namespace Modules\Tags;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Tags\Commands\UntagSomething;

class Cleanup
{
    use DispatchesJobs;

    public function handle($owner)
    {
        if ($owner instanceof StoresTags) {
            foreach ($owner->tags as $tag) {
                $this->dispatch(new UntagSomething($owner, $tag));
            }
        }
    }
}
