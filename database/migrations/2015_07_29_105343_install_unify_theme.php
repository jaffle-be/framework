<?php

use App\Theme\ThemeInstallationMigration;

class InstallUnifyTheme extends ThemeInstallationMigration
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
            'key' => 'footerAboutTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
            'fr'  => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
            'de'  => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
            'en'  => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
        ],

        [
            'key' => 'footerAboutText',
            'text' => true,
            'nl'  => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
            'fr'  => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
            'de'  => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
            'en'  => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
        ],

        [
            'key' => 'footerPostsTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
            'fr'  => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
            'de'  => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
            'en'  => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
        ],

        [
            'key' => 'footerLinksTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
            'fr'  => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
            'de'  => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
            'en'  => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
        ],

        [
            'key' => 'footerContactTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
            'fr'  => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
            'de'  => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
            'en'  => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
        ],

        [
            'key' => 'footerSocialIconsTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
            'fr'  => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
            'de'  => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
            'en'  => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
        ],

        [
            'key' => 'footerNewsletterTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
            'fr'  => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
            'de'  => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
            'en'  => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
        ],

        [
            'key' => 'footerNewsletterText',
            'text' => true,
            'nl'  => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
            'fr'  => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
            'de'  => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
            'en'  => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
        ],

        [
            'key' => 'footerTweetsTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
            ],
            'fr'  => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
            ],
            'de'  => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
            ],
            'en'  => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
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

    ];

    protected $defaults = [
        'header'           => 'header_default',
        'footer'           => 'footer_default',
        'breadcrumbs'      => 'breadcrumbs-1',
        'pagination'       => 'pagination-1',
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

    ];

}
