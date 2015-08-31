<?php

use App\Theme\ThemeInstallationMigration;

class InstallUnifyTheme extends ThemeInstallationMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $defaults = [
        'layoutHeader' => 'header_default',
        'layoutFooter' => 'footer_default',
        'layoutFooterAboutTitle' => [
            "en" => "Who we are",
            "nl" => "Wie wij zijn",
        ],
        'layoutFooterAboutText' => [
            "en" => "We're a group of people all with a passion for their jobs. This makes us a group of professionals, ready to help you and your firm get re-digitalised",
            "nl" => "We zijn een groep mensen die stuk voor stuk een passie hebben voor iets. Samen vormen we een geheel van professionals die uw bedrijf snel digitaal verder helpen.",
        ],
        'layoutFooterPostsTitle' => [
            "en" => "What happens here",
            "nl" => "Onze laatste updates",
        ],
        'layoutFooterLinksTitle' => [
            "en" => "Read these",
            "nl" => "Interessante links",
        ],
        'layoutFooterContactTitle' => [
            "en" => "Get in touch",
            "nl" => "Laat van je horen",
        ],
        'layoutFooterSocialIconsTitle' => [
            "en" => "Time to get social",
            "nl" => "Time to get social",
        ],
        'layoutFooterNewsletterTitle' => [
            "en" => "Stay up to date",
            "nl" => "Op de hoogte blijven",
        ],
        'layoutFooterNewsletterText' => [
            "en" => "fill in your email and from time to time, we'll keep in touch. All so you can easily keep track of what we're up to.",
            "nl" => "vul je email in als je sneller op de hoogte wil blijven van wat er bij ons leeft.",
        ],
        'layoutFooterTweetsTitle' => [
            "en" => "Tweets in action",
            "nl" => "Tweets in action",
        ],
        'layoutBreadcrumbs'  => 'breadcrumbs-1',
        'layoutPagination'   => 'pagination-1',
        'layoutErrorPage'    => 'one',
    ];

    protected $settings = [

        [
            'key'  => 'layoutHeader',
            'type' => 'select',
            'nl'   => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'fr'   => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'de'   => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'en'   => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
        ],

        [
            'key'  => 'layoutFooter',
            'type' => 'select',
            'nl'   => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'fr'   => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'de'   => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'en'   => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
        ],

        [
            'key'  => 'layoutFooterAboutTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
            'fr'   => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
            'de'   => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
            'en'   => [
                'name'        => 'footer about title',
                'explanation' => 'footer about title'
            ],
        ],

        [
            'key'  => 'layoutFooterAboutText',
            'type' => 'text',
            'nl'   => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
            'fr'   => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
            'de'   => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
            'en'   => [
                'name'        => 'footer about text',
                'explanation' => 'footer about text'
            ],
        ],

        [
            'key'  => 'layoutFooterPostsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
            'fr'   => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
            'de'   => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
            'en'   => [
                'name'        => 'footer posts title',
                'explanation' => 'footer posts title'
            ],
        ],

        [
            'key'  => 'layoutFooterLinksTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
            'fr'   => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
            'de'   => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
            'en'   => [
                'name'        => 'footer links title',
                'explanation' => 'footer links title'
            ],
        ],

        [
            'key'  => 'layoutFooterContactTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
            'fr'   => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
            'de'   => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
            'en'   => [
                'name'        => 'footer contact title',
                'explanation' => 'footer contact title'
            ],
        ],

        [
            'key'  => 'layoutFooterSocialIconsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
            'fr'   => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
            'de'   => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
            'en'   => [
                'name'        => 'footer social icons title',
                'explanation' => 'footer social icons title'
            ],
        ],

        [
            'key'  => 'layoutFooterNewsletterTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
            'fr'   => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
            'de'   => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
            'en'   => [
                'name'        => 'footer newsletter title',
                'explanation' => 'footer newsletter title'
            ],
        ],

        [
            'key'  => 'layoutFooterNewsletterText',
            'type' => 'text',
            'nl'   => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
            'fr'   => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
            'de'   => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
            'en'   => [
                'name'        => 'footer newsletter text',
                'explanation' => 'footer newsletter text'
            ],
        ],

        [
            'key'  => 'layoutFooterTweetsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
            ],
            'fr'   => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
            ],
            'de'   => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
            ],
            'en'   => [
                'name'        => 'footer recent tweets title',
                'explanation' => 'footer recent tweets title'
            ],
        ],

        [
            'key'  => 'layoutBreadcrumbs',
            'type' => 'select',
            'nl'   => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
            'fr'   => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
            'de'   => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
            'en'   => [
                'name'        => 'breadcrumbs',
                'explanation' => 'breadcrumbs style'
            ],
        ],

        [
            'key'  => 'layoutPagination',
            'type' => 'select',
            'nl'   => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
            ],
            'fr'   => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
            ],
            'de'   => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
            ],
            'en'   => [
                'name'        => 'pagination',
                'explanation' => 'pagination style'
            ],
        ],

        [
            'key'  => 'layoutErrorPage',
            'type' => 'select',
            'nl'   => [
                'name'        => 'error page',
                'explanation' => 'error page style'
            ],
            'fr'   => [
                'name'        => 'error page',
                'explanation' => 'error page style'
            ],
            'de'   => [
                'name'        => 'error page',
                'explanation' => 'error page style'
            ],
            'en'   => [
                'name'        => 'error page',
                'explanation' => 'error page style'
            ],
        ],

    ];

    protected $options = [

        'layoutHeader' => [

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

        'layoutFooter' => [
            ['value' => 'footer_default'],
            ['value' => 'footer_v1'],
            ['value' => 'footer_v2'],
            ['value' => 'footer_v3'],
            ['value' => 'footer_v4'],
            ['value' => 'footer_v5'],
            ['value' => 'footer_v6'],
        ],

        'layoutBreadcrumbs'  => [
            ['value' => 'breadcrumbs-1'],
            ['value' => 'breadcrumbs-2'],
            ['value' => 'breadcrumbs-3'],
            ['value' => 'breadcrumbs-4'],
            ['value' => 'breadcrumbs-5'],
        ],

        'layoutPagination'   => [
            ['value' => 'pagination-1'],
            ['value' => 'pagination-2'],
            ['value' => 'pagination-3'],
        ],

        'layoutErrorPage'    => [
            ['value' => 'one'],
            ['value' => 'two'],
            ['value' => 'three'],
            ['value' => 'four'],
        ],

    ];

}
