<?php

return [

    /**
     * path should be relative to the public path, no need for a trailing slash
     */
    'path'   => 'media',

    'owners' => [
        'blog'      => App\Blog\Post::class,
        'portfolio' => App\Portfolio\Project::class,
    ],

    /**
     * HEADS UP:
     * In the admin section we always need a 340 dimension in the detail pages
     * And a 150 dimension in the overview pages
     *
     */
    'sizes'  => [

        'blog' => [
            '1140',
            '850',
            '460',
            '410',
            '360',
            '340',
            '150',
            '60',
        ],

        'portfolio' => [
            '1280',
            '1140',
            '860',
            '660',
            '640',
            '570',
            '512',
            '430',
            '380',
            '285',
            '270',
            '150',
        ]
    ],

];