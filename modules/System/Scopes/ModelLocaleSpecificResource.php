<?php

namespace Modules\System\Scopes;

use Illuminate\Http\Request;

/**
 * Class ModelLocaleSpecificResource
 * @package Modules\System\Scopes
 */
trait ModelLocaleSpecificResource
{
    public static function bootModelLocaleSpecificResource()
    {
        /** @var Request $request */
        $request = app('request');

        if (app()->runningInConsole() && ! env('RUNNING_TESTS', false)) {
            return;
        }

        if (! starts_with($request->getRequestUri(), ['/admin', '/api'])) {
            static::addGlobalScope(app()->make('Modules\System\Scopes\ModelLocaleSpecificResourceScope'));
        }
    }

    /**
     * @return mixed
     */
    public function locale()
    {
        return $this->belongsTo('Modules\System\Locale');
    }

    /**
     * @param array $items
     * @return LocalisedResourceCollection
     */
    public function newCollection(array $items = [])
    {
        return new LocalisedResourceCollection($items);
    }
}
