<?php

namespace Modules\Tags;

use Illuminate\Support\Collection;

/**
 * Class CollectionWithTaggables
 * @package Modules\Tags
 */
trait CollectionWithTaggables
{
    /**
     * @return Collection
     */
    public function getUniqueTags()
    {
        $tags = new Collection();

        foreach ($this->items as $item) {
            foreach ($item->tags as $tag) {
                $tags->put($tag->id, $tag);
            }
        }

        return $tags;
    }
}
