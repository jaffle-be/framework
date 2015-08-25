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
            '460x',
            '340x',
            '150x',
            '60x',
        ],

        'portfolio' => [
            '1280x',
            '340x',
            '270x',
            '150x',
        ],

        'user' => [
            '1280x',
            '512x',
            '340x',
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