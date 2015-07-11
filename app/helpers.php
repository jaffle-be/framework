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
        $app = app('request')->getHost() != substr(config('app.url'), strlen('http://')) ? 'stores' : 'app';
    }

    return $app;
}

function translation_input(Request $request, array $except = [])
{
    $input = $request->except($except);

    foreach ($input['translations'] as $locale => $translation) {
        $input[$locale] = $translation;
    }

    unset($input['translations']);

    return $input;
}