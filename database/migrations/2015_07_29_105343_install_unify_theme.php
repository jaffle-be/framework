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
            'key' => 'breadcrumbs',
            'nl'  => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
            'fr'  => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
            'de'  => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
            'en'  => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
        ],

        [
            'key' => 'pagination',
            'nl'  => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
            ],
            'fr'  => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
            ],
            'de'  => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
            ],
            'en'  => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
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

        [
            'key' => 'teamOverview',
            'nl'  => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
            'fr'  => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
            'de'  => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
            'en'  => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
        ],

        [
            'key' => 'teamDetail',
            'nl'  => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
            'fr'  => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
            'de'  => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
            'en'  => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
        ],

        [
            'key'     => 'teamHiring',
            'boolean' => true,
            'nl'      => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
            'fr'      => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
            'de'      => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
            'en'      => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
        ],

        [
            'key'     => 'teamHireMe',
            'boolean' => true,
            'nl'      => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
            'fr'      => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
            'de'      => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
            'en'      => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
        ],

        [
            'key' => 'portfolioColumns',
            'nl'  => [
                'name'        => 'portfolio columns',
                'explanation' => 'portfolio columns'
            ],
            'fr'  => [
                'name'        => 'portfolio columns',
                'explanation' => 'portfolio columns'
            ],
            'de'  => [
                'name'        => 'portfolio columns',
                'explanation' => 'portfolio columns'
            ],
            'en'  => [
                'name'        => 'portfolio columns',
                'explanation' => 'portfolio columns'
            ],
        ],

        [
            'key'     => 'portfolioGrid',
            'boolean' => true,
            'nl'      => [
                'name'        => 'portfolio grid',
                'explanation' => 'portfolio grid'
            ],
            'fr'      => [
                'name'        => 'portfolio grid',
                'explanation' => 'portfolio grid'
            ],
            'de'      => [
                'name'        => 'portfolio grid',
                'explanation' => 'portfolio grid'
            ],
            'en'      => [
                'name'        => 'portfolio grid',
                'explanation' => 'portfolio grid'
            ],
        ],

        [
            'key'     => 'portfolioSpaced',
            'boolean' => true,
            'nl'      => [
                'name'        => 'portfolio spaced',
                'explanation' => 'portfolio spaced'
            ],
            'fr'      => [
                'name'        => 'portfolio spaced',
                'explanation' => 'portfolio spaced'
            ],
            'de'      => [
                'name'        => 'portfolio spaced',
                'explanation' => 'portfolio spaced'
            ],
            'en'      => [
                'name'        => 'portfolio spaced',
                'explanation' => 'portfolio spaced'
            ],
        ],

    ];

    protected $defaults = [
        'header'           => 'header_default',
        'footer'           => 'footer_default',
        'breadcrumbs'      => 'breadcrumbs-1',
        'pagination'       => 'pagination-1',
        'blogOverview'     => 'masonry',
        'blogDetail'       => 'full-width/large-detail',
        'contactLayout'    => 'contact-1',
        'teamOverview'     => 'team-1',
        'teamDetail'       => 'member-1',
        'portfolioColumns' => 3
    ];

    protected $options = [

        'header'           => [

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

        'footer'           => [
            ['value' => 'footer_default'],
            ['value' => 'footer_v1'],
            ['value' => 'footer_v2'],
            ['value' => 'footer_v3'],
            ['value' => 'footer_v4'],
            ['value' => 'footer_v5'],
            ['value' => 'footer_v6'],
            ['value' => 'footer_v7'],
        ],

        'breadcrumbs'      => [
            ['value' => 'breadcrumbs-1'],
            ['value' => 'breadcrumbs-2'],
            ['value' => 'breadcrumbs-3'],
            ['value' => 'breadcrumbs-4'],
            ['value' => 'breadcrumbs-5'],
        ],

        'pagination'       => [
            ['value' => 'pagination-1'],
            ['value' => 'pagination-2'],
            ['value' => 'pagination-3'],
        ],

        'blogOverview'     => [
            ['value' => 'full-width/large-overview'],
            ['value' => 'full-width/large-overview-simple'],
            ['value' => 'full-width/medium-overview'],

            ['value' => 'sidebar-left/large-overview'],
            ['value' => 'sidebar-left/large-overview-simple'],
            ['value' => 'sidebar-left/medium-overview'],
            ['value' => 'sidebar-left/medium-overview-simple'],

            ['value' => 'sidebar-right/large-overview'],
            ['value' => 'sidebar-right/large-overview-simple'],
            ['value' => 'sidebar-right/medium-overview'],
            ['value' => 'sidebar-right/medium-overview-simple'],

            ['value' => 'masonry'],
            ['value' => 'timeline'],
        ],

        'blogDetail'       => [
            ['value' => 'full-width/large-detail'],
            ['value' => 'full-width/large-detail-simple'],
            ['value' => 'sidebar-left/large-detail'],
            ['value' => 'sidebar-left/large-detail-simple'],
            ['value' => 'sidebar-right/large-detail'],
            ['value' => 'sidebar-right/large-detail-simple'],
        ],

        'contactLayout'    => [
            ['value' => 'contact-1'],
            ['value' => 'contact-2'],
            ['value' => 'contact-3'],
            ['value' => 'contact-4'],
            ['value' => 'contact-advanced'],
        ],

        'teamOverview'     => [
            ['value' => 'team-1'],
            ['value' => 'team-2'],
            ['value' => 'team-3'],
        ],

        'teamDetail'       => [
            ['value' => 'member-1'],
            ['value' => 'member-2'],
            ['value' => 'member-3'],
        ],

        'portfolioColumns' => [
            ['value' => '2'],
            ['value' => '3'],
            ['value' => '4'],
        ],

    ];

}
