<?php

/**
 * Used to help set the configuration through json on the front side.
 * Found in the actual views, will most likely be at the same html element
 * where the angular page specific controller is assigned
 *
 * @return string
 */
function system_options()
{
    $options = config('blog');

    $locales = array_map(function ($item) {

        return [
            'locale' => $item,
            'active' => $item == app()->getLocale()
        ];
    }, $options['locales']);

    $options['locales'] = array_combine($options['locales'], $locales);

    $options['summernote'] = config('system.summernote');

    return json_encode($options);
}