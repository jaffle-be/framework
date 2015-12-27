<?php

namespace Modules\Tags\Commands;

use App\Jobs\Job;
use Modules\Tags\Tag;

/**
 * Class CreateNewTag
 * @package Modules\Tags\Commands
 */
class CreateNewTag extends Job
{
    protected $locale;

    protected $name;

    /**
     * @param $locale
     * @param $name
     */
    public function __construct($locale, $name)
    {
        $this->locale = $locale;
        $this->name = $name;
    }

    /**
     * @param Tag $tag
     * @return bool
     */
    public function handle(Tag $tag)
    {
        $payload = [
            $this->locale => [
                'name' => $this->name,
            ],
        ];

        $tag = $tag->create($payload);

        return $tag ?: false;
    }
}
