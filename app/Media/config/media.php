<?php

return [

    /**
     * path should be relative to the public path, no need for a trailing slash
     */
    'path'   => 'media',

    'owners' => [
        'blog'      => App\Blog\Post::class,
        'portfolio' => App\Portfolio\Project::class,
        'user' => App\Users\user::class,
        'account-logo' => App\Account\AccountLogo::class,
        'client' => App\Account\Client::class,
    ],

    /**
     * HEADS UP:
     * In the admin section we always need a 340 dimension in the detail pages (image uploader)
     * And a 150 dimension in the overview pages
     *
     */
    'sizes'  => [

        'blog' => [
            '1140x',
            '850x',
            '460x',
            '410x',
            '360x',
            '340x',
            '150x',
            '60x',
        ],

        'portfolio' => [
            '1280x',
            '1140x',
            '860x',
            '660x',
            '640x',
            '570x',
            '512x',
            '430x',
            '380x',
            '285x',
            '270x',
            '150x',
        ],

        'user' => [
            '1280x',
            '512x',
            '380x',
            '340x',
            '200x',
            '80x'
        ],

        'account-logo' => [
            '340x',
            'x40'
        ],

        'client' => [
            '340x',
            'x40',
            'x90',
        ]
    ],

];