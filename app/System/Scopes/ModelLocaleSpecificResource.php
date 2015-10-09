<?php namespace App\System\Scopes;

use Illuminate\Http\Request;

trait ModelLocaleSpecificResource
{
    public function locale()
    {
        return $this->belongsTo('App\System\Locale');
    }

    public static function bootModelLocaleSpecificResource()
    {
        /** @var Request $request */
        $request = app('request');

        if(app()->runningInConsole())
        {
            return;
        }

        if(!starts_with($request->getRequestUri(), ['/admin', '/api']))
        {
            static::addGlobalScope(app()->make('App\System\Scopes\ModelLocaleSpecificResourceScope'));
        }
    }

    public function newCollection(array $items = [])
    {
        return new LocalisedResourceCollection($items);
    }

}