<?php

use App\Theme\ThemeMigration;

class InstallUnifyTheme extends ThemeMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $settings = [

        [
            'key' => 'header',
            'nl'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'fr'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'de'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'en'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
        ],

        [
            'key' => 'footer',
            'nl'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'fr'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'de'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'en'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
        ],

        [
            'key' => 'blogOverview',
            'nl'  => [
                'name'        => 'blog overview',
                'explanation' => 'blog overview'
            ],
            'fr'  => [
                'name'        => 'blog overview',
                'explanation' => 'blog overview'
            ],
            'de'  => [
                'name'        => 'blog overview',
                'explanation' => 'blog overview'
            ],
            'en'  => [
                'name'        => 'blog overview',
                'explanation' => 'blog overview'
            ],
        ],

        [
            'key' => 'blogDetail',
            'nl'  => [
                'name'        => 'blog detail',
                'explanation' => 'blog detail'
            ],
            'fr'  => [
                'name'        => 'blog detail',
                'explanation' => 'blog detail'
            ],
            'de'  => [
                'name'        => 'blog detail',
                'explanation' => 'blog detail'
            ],
            'en'  => [
                'name'        => 'blog detail',
                'explanation' => 'blog detail'
            ],
        ],

        [
            'key' => 'contactLayout',
            'nl'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
            'fr'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
            'de'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
            'en'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
        ],
    ];

    protected $defaults = [
        'header'        => 'header_default',
        'footer'        => 'footer_default',
        'blogOverview'  => 'masonry',
        'blogDetail'    => 'full-width/large-detail',
        'contactLayout' => 'contact-1',
    ];

    protected $options = [

        'header'        => [

            ['value' => 'header_default'],
            ['value' => 'header_v1'],
            ['value' => 'header_v2'],
            ['value' => 'header_v3'],
            ['value' => 'header_v4'],
            ['value' => 'header_v5'],
            ['value' => 'header_v6_border_bottom'],
            ['value' => 'header_v6_classic_dark'],
            ['value' => 'header_v6_classic_white'],
            ['value' => 'header_v6_dark_dropdown'],
            ['value' => 'header_v6_dark_res_nav'],
            ['value' => 'header_v6_dark_scroll'],
            ['value' => 'header_v6_dark_search'],
            ['value' => 'header_v6_semi_dark_transparent'],
            ['value' => 'header_v6_semi_white_transparent'],
            ['value' => 'header_v6_transparent'],
        ],

        'footer'        => [
            ['value' => 'footer_default'],
            ['value' => 'footer_v1'],
            ['value' => 'footer_v2'],
            ['value' => 'footer_v3'],
            ['value' => 'footer_v4'],
            ['value' => 'footer_v5'],
            ['value' => 'footer_v6'],
            ['value' => 'footer_v7'],
        ],

        'blogOverview'  => [
            ['value' => 'full-width/large-overview'],
            ['value' => 'full-width/large-overview-simple'],
            ['value' => 'full-width/medium-overview'],

            ['value' => 'sidebar-left/large-overview'],
            ['value' => 'sidebar-left/large-overview-simple'],
            ['value' => 'sidebar-right/large-overview'],
            ['value' => 'sidebar-right/large-overview-simple'],

            ['value' => 'sidebar-left/medium-overview'],
            ['value' => 'sidebar-left/medium-overview-simple'],
            ['value' => 'sidebar-right/medium-overview'],
            ['value' => 'sidebar-right/medium-overview-simple'],

            ['value' => 'masonry'],
            ['value' => 'timeline'],
        ],

        'blogDetail'    => [
            ['value' => 'full-width/large-detail'],
            ['value' => 'full-width/large-detail-simple'],
            ['value' => 'sidebar-left/large-detail'],
            ['value' => 'sidebar-right/large-detail'],
            ['value' => 'sidebar-right/large-detail-simple'],
        ],

        'contactLayout' => [
            ['value' => 'contact-1'],
            ['value' => 'contact-2'],
            ['value' => 'contact-3'],
            ['value' => 'contact-4'],
            ['value' => 'contact-advanced'],
        ]

    ];

}
