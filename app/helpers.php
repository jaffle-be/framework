<?php
use Illuminate\Http\Request;

/**
 * @return string
 */
function app_detect()
{
    static $app;

    if (!$app) {
        //if the host is not the main host we default to the stores application
        //we determine the main host by using the main application
        $app = app('request')->getHost() != preg_replace('#https?://#', '', config('app.url')) ? 'stores' : 'app';
    }

    return $app;
}


function route_subdomain()
{
    static $cached = false;

    if ($cached) {
        return $cached;
    }

    $domain = config('app.subdomain');

    $url = config('app.url');

    $url = preg_replace('#https?://#', '', $url);

    $cached = $domain . '.' . $url;

    return $cached;
}



function translation_input(Request $request, array $except = [])
{
    $input = $request->except($except);

    if(isset($input['translations']))
    {
        foreach ($input['translations'] as $locale => $translation) {
            $input[$locale] = $translation;
        }

        unset($input['translations']);
    }

    return $input;
}