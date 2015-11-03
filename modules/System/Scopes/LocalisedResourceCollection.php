<?php namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Collection;

class LocalisedResourceCollection extends Collection
{
    public function byLocale()
    {
        $collection = $this->groupBy('locale_id');

        $response = new Collection();

        $locales = app('Modules\System\Locale')->all();

        foreach($locales as $locale)
        {
            $response->put($locale->slug, $collection->get($locale->id, new Collection()));
        }

        return $response;
    }

    public function toArray()
    {
        $byLocales = $this->byLocale();

        $response = [];

        foreach($byLocales as $locale => $items)
        {
            $response[$locale] = [];

            foreach($items as $item)
            {
                $response[$locale][] = $item->toArray();
            }

        }

        return $response;
    }
}