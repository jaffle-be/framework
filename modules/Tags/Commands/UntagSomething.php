<?php

namespace Modules\Tags\Commands;

use App\Jobs\Job;

/**
 * Class UntagSomething
 * @package Modules\Tags\Commands
 */
class UntagSomething extends Job
{
    protected $owner;

    protected $tag;

    /**
     * @param $owner
     * @param $tag
     */
    public function __construct($owner, $tag)
    {
        $this->owner = $owner;
        $this->tag = $tag;
    }

    public function handle()
    {
        $this->owner->tags()->detach($this->tag->id);

        if ($this->tag->content()->count() == 0) {
            $this->tag->delete();
        }
    }
}
