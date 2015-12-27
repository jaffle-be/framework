<?php

namespace Modules\Tags\Commands;

use App\Jobs\Job;
use Modules\Tags\Tag;

class UpdateTag extends Job
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
     *
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
