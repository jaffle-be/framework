<?php

return [

    /*
     * path should be relative to the public path, no need for a trailing slash
     */
    'path' => env('APP_ENV') == 'testing' ? 'media_testing' : 'media',
    'owners' => [
        'pages' => Modules\Pages\Page::class,
        'blog' => Modules\Blog\Post::class,
        'portfolio' => Modules\Portfolio\Project::class,
        'user' => Modules\Users\User::class,
        'account-logo' => Modules\Account\AccountLogo::class,
        'client' => Modules\Account\Client::class,
        'product' => Modules\Shop\Product\Product::class,
        'newsletter' => Modules\Marketing\Newsletter\Campaign::class,
    ],
    'admin' => [
        'image' => [
            '512x',
        ],
        'video' => [

        ],
    ],
    'videos' => [
        //these values should be coming from the theme
    ],

];
