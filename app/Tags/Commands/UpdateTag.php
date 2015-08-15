<?php namespace App\Tags\Commands;

use App\Jobs\Job;
use App\Tags\Tag;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateTag extends Job implements SelfHandling
{

    /**
     * @var Tag
     */
    protected $tag;

    /**
     * @var array
     */
    protected $input;

    /**
     * @param Tag   $tag
     * @param array $input
     */
    public function __construct(Tag $tag, array $input)
    {
        $this->tag = $tag;
        $this->input = $input;
    }

    /**
     * @return Tag|bool
     */
    public function handle()
    {
        $this->tag->fill($this->input);

        return $this->tag->save() ? $this->tag : false;
    }
}