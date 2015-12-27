<?php

namespace Modules\Tags;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Tags\Commands\UntagSomething;

/**
 * Class Cleanup
 * @package Modules\Tags
 */
class Cleanup
{
    use DispatchesJobs;

    /**
     * @param $owner
     */
    public function handle($owner)
    {
        if ($owner instanceof StoresTags) {
            foreach ($owner->tags as $tag) {
                $this->dispatch(new UntagSomething($owner, $tag));
            }
        }
    }
}
