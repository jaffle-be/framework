<?php

namespace Modules\Tags\Commands;

use App\Jobs\Job;
use Modules\Tags\Tag;

/**
 * Class UpdateTag
 * @package Modules\Tags\Commands
 */
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
     * @param Tag $tag
     * @param array $input
     */
    public function __construct(Tag $tag, array $input)
    {
        $this->tag = $tag;
        $this->input = $input;
    }

    /**
     *
     */
    public function handle()
    {
        $this->tag->fill($this->input);

        return $this->tag->save() ? $this->tag : false;
    }
}
