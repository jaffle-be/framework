<?php

namespace Modules\System\Scopes;

use Illuminate\Http\Request;

trait ModelLocaleSpecificResource
{

    public static function bootModelLocaleSpecificResource()
    {
        /** @var Request $request */
        $request = app('request');

        if (app()->runningInConsole() && !env('RUNNING_TESTS', false)) {
            return;
        }

        if (!starts_with($request->getRequestUri(), ['/admin', '/api'])) {
            static::addGlobalScope(app()->make('Modules\System\Scopes\ModelLocaleSpecificResourceScope'));
        }
    }

    public function locale()
    {
        return $this->belongsTo('Modules\System\Locale');
    }

    public function newCollection(array $items = [])
    {
        return new LocalisedResourceCollection($items);
    }
}
