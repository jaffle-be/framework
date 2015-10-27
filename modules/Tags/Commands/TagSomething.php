<?php namespace Modules\Tags\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Tags\Tag;

class TagSomething extends Job implements SelfHandling
{

    protected $owner;

    protected $tag;

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