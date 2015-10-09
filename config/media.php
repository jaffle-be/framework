<?php

return [

    /**
     * path should be relative to the public path, no need for a trailing slash
     */
    'path'   => 'media',

    'owners' => [
        'blog'         => App\Blog\Post::class,
        'portfolio'    => App\Portfolio\Project::class,
        'user'         => App\Users\User::class,
        'account-logo' => App\Account\AccountLogo::class,
        'client'       => App\Account\Client::class,
    ],

    'admin'  => [
        'image' => [
            '512x',
        ],
        'video' => [

        ]
    ],

    'videos' => [
        //these values should be coming from the theme
    ]

];