<?php

namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class SimpleTranslationCollection
 * @package Modules\System\Translatable
 */
class SimpleTranslationCollection extends Collection
{
    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return with(new Collection($this->items))->keyBy('locale')->toArray();
    }

    /**
     * Get the collection of items as JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return parent::toJson(JSON_FORCE_OBJECT);
    }
}
