<?php namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Collection;

class LocalisedResourceCollection extends Collection
{
    public function byLocale()
    {
        $collection = $this->groupBy('locale_id');

        $response = new Collection();

        $locales = app('Modules\System\Locale')->all();

        foreach($collection as $locale_id => $locale_items)
        {
            $response->put($locales->find($locale_id)->slug, $locale_items);
        }

        return $response;
    }
}