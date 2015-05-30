<?php

function blog_options()
{
    $options = config('blog');

    $locales = array_map(function ($item) {

        return [
            'locale' => $item,
            'active' => $item == 'nl'
        ];

    }, $options['locales']);

    $options['locales'] = array_combine($options['locales'], $locales);

    return json_encode($options);
}