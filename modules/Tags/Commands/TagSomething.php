<?php

namespace Modules\Tags\Commands;

use App\Jobs\Job;
use Modules\Tags\Tag;

/**
 * Class TagSomething
 * @package Modules\Tags\Commands
 */
class TagSomething extends Job
{
    protected $owner;

    protected $tag;

    /**
     * @param Tag $tag
     * @param $owner
     */
    public function __construct(Tag $tag, $owner)
    {
        $this->tag = $tag;
        $this->owner = $owner;
    }

    public function handle()
    {
        $this->owner->tags()->attach($this->tag->id);
    }
}
