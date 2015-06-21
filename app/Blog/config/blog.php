<?php

return [

    //since we generally do not want to touch the ratio of the image, we only provide widths
    //if we do we will crop as big as we can to the provided ratio, and then resize to the given size
    //sizes are in px. @todo, cropping isn't implemented yet
    'image_sizes' => [
        '1140',
        '850',
        '460',
        '410',
        '360',
        '340',
        '150',
        '60',

    ],

    'locale'  => App::getLocale(),

    'locales' => ['nl', 'fr', 'en', 'de']

];