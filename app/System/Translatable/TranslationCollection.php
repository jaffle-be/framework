<?php namespace App\System\Translatable;

use App\System\Locale;
use Illuminate\Database\Eloquent\Collection;

class TranslationCollection extends Collection
{
    public function toArray()
    {
        $locales = Locale::all();

        $translations = with(new Collection($this->items))->keyBy('locale_id')->toArray();

        $result = [];

        foreach($locales as $locale)
        {
            if(isset($translations[$locale->id]))
            {
                $result[$locale->slug] = $translations[$locale->id];
            }
        }

        return $result;
    }

    public function toJson($options = 0)
    {
        return parent::toJson(JSON_FORCE_OBJECT);
    }
}