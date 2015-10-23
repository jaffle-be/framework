<?php

return [

    'installed'          => false,

    /*
    |--------------------------------------------------------------------------
    | Application Locales
    |--------------------------------------------------------------------------
    |
    | Contains an array with the applications available locales.
    |
    */
    'locales'            => ['en', 'nl', 'fr', 'de'],

    /*
    |--------------------------------------------------------------------------
    | Use fallback
    |--------------------------------------------------------------------------
    |
    | Determine if fallback locales are returned by default or not. To add
    | more flexibility and configure this option per "translatable"
    | instance, this value will be overridden by the property
    | $useTranslationFallback when defined
    */
    'use_fallback'       => false,

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    |
    | A fallback locale is the locale being used to return a translation
    | when the requested translation is not existing. To disable it
    | set it to false.
    |
    */
    'fallback_locale'    => 'en',

    /*
    |--------------------------------------------------------------------------
    | Translation Suffix
    |--------------------------------------------------------------------------
    |
    | Defines the default 'Translation' class suffix. For example, if
    | you want to use CountryTrans instead of CountryTranslation
    | application, set this to 'Trans'.
    |
    */
    'translation_suffix' => 'Translation',

    /*
    |--------------------------------------------------------------------------
    | Locale key
    |--------------------------------------------------------------------------
    |
    | Defines the 'locale' field name, which is used by the
    | translation model.
    |
    */
    'locale_key'         => 'locale',

    /*
    |--------------------------------------------------------------------------
    | Make translated attributes always fillable
    |--------------------------------------------------------------------------
    |
    | If true, translatable automatically sets
    | translated attributes as fillable.
    |
    | WARNING!
    | Set this to true only if you understand the security risks.
    |
    */
    'always_fillable'    => false,

    'seo'                => [

        'webmaster_tools' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null
        ],

        'providers'       => [
            App\System\Seo\Providers\Generic::class,
            App\System\Seo\Providers\Google::class,
            App\System\Seo\Providers\Twitter::class,
            App\System\Seo\Providers\Facebook::class,
        ],

        //these hold values per provider, that should have defaults per website
        //but should not be included in every request, mostly depending on the 'type'
        //that's been defined, we'll include a subset of attributes specific to that type only.
        'defaults' => [
            'twitter' => [

            ],
            'facebook' => [
                'article' => [
                    //link to facebook profile or facebook id
                    'author' => null,
                    //link to facebook profile or facebook id
                    'publisher' => null,
                ]
            ],
            'google'=> [

            ]
        ],

        'generic'         => [
            'title'       => 'Digiredo', // set false to total remove
            'description' => 'A multipurpose platform', // set false to total remove
            'keywords'    => 'a multipurpose larangular platform'
        ],

        'twitter'         => [
            'card'    => 'summary_large_image',
            'site'    => '@twarlop',
            'creator' => '@twarlop',
        ],

        'facebook'        => [
            'app_id'      => null,
            'type'        => 'website',
            'title'       => 'Digiredo', // set false to total remove
            'description' => 'A multipurpose platform', // set false to total remove
            'url'         => false,
            'site_name'   => 'digiredo.be',
            'images'      => [],
        ],

        'google'          => [
            'type'        => 'website',
            'site_name'   => 'digiredo.be',
            'title'       => 'Digiredo', // set false to total remove
            'description' => 'A multipurpose platform', // set false to total remove
            'url'         => false,
            'images'      => [],
        ],

        'owners'          => [
            'pages'     => App\Pages\Page::class,
            'blog'      => App\Blog\Post::class,
            'portfolio' => App\Portfolio\Project::class,
        ]

    ],
];