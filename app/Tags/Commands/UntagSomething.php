<?php namespace App\Tags\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class UntagSomething extends Job implements SelfHandling{

    protected $owner;

    protected $tag;

    public function __construct($owner, $tag)
    {
        $this->owner = $owner;
        $this->tag = $tag;
    }

    public function handle()
    {
        $this->owner->tags()->detach($this->tag->id);

        if ($this->tag->posts()->count() == 0) {
            $this->tag->delete();
        }
    }

}