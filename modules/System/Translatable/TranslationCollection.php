<?php

namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Collection;
use Modules\System\Locale;

/**
 * Class TranslationCollection
 * @package Modules\System\Translatable
 */
class TranslationCollection extends Collection
{
    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        $locales = Locale::all();

        $translations = with(new Collection($this->items))->keyBy('locale_id')->toArray();

        $result = [];

        foreach ($locales as $locale) {
            if (isset($translations[$locale->id])) {
                $result[$locale->slug] = $translations[$locale->id];
            }
        }

        return $result;
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
