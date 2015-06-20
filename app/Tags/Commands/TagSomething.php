<?php namespace App\Tags\Commands;

use App\Commands\Command;
use App\Tags\Tag;
use Illuminate\Contracts\Bus\SelfHandling;

class TagSomething extends Command implements SelfHandling
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