<?php

use Modules\Theme\ThemeSettingMigration;

class InstallUnifyThemePortfolio extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $defaults = [
        'portfolioColumns' => 3,
        'portfolioMainTitleOverview' => [
            'nl' => "Wat we allemaal gemaakt hebben",
            'en' => "What we've been creating",
        ],
        'portfolioProjectDetails' => [
            'nl' => "De reutemeteut",
            'en' => "The details",
        ],
        'portfolioProjectDescription' => [
            'nl' => "Ons verhaal",
            'en' => "Our story about this",
        ],
    ];

    protected $settings = [

        [
            'key' => 'portfolioColumns',
            'type' => 'select',
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
            'type' => 'boolean',
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
            'type' => 'boolean',
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


        [
            'key' => 'portfolioMainTitleOverview',
            'type' => 'string',
            'nl'   => [
                'name'        => 'portfolio main title overview',
                'explanation' => 'portfolio main title overview'
            ],
            'fr'   => [
                'name'        => 'portfolio main title overview',
                'explanation' => 'portfolio main title overview'
            ],
            'de'   => [
                'name'        => 'portfolio main title overview',
                'explanation' => 'portfolio main title overview'
            ],
            'en'   => [
                'name'        => 'portfolio main title overview',
                'explanation' => 'portfolio main title overview'
            ],
        ],

        [
            'key' => 'portfolioProjectDetails',
            'type' => 'string',
            'nl'   => [
                'name'        => 'portfolio project details title',
                'explanation' => 'portfolio project details title'
            ],
            'fr'   => [
                'name'        => 'portfolio project details title',
                'explanation' => 'portfolio project details title'
            ],
            'de'   => [
                'name'        => 'portfolio project details title',
                'explanation' => 'portfolio project details title'
            ],
            'en'   => [
                'name'        => 'portfolio project details title',
                'explanation' => 'portfolio project details title'
            ],
        ],

        [
            'key' => 'portfolioProjectDescription',
            'type' => 'string',
            'nl'   => [
                'name'        => 'portfolio project description title',
                'explanation' => 'portfolio project description title'
            ],
            'fr'   => [
                'name'        => 'portfolio project description title',
                'explanation' => 'portfolio project description title'
            ],
            'de'   => [
                'name'        => 'portfolio project description title',
                'explanation' => 'portfolio project description title'
            ],
            'en'   => [
                'name'        => 'portfolio project description title',
                'explanation' => 'portfolio project description title'
            ],
        ],
    ];

    protected $options = [

        'portfolioColumns' => [
            ['value' => '2'],
            ['value' => '3'],
            ['value' => '4'],
        ],

    ];

}
