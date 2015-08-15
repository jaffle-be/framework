<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemePortfolio extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

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
    ];

    protected $defaults = [
        'portfolioColumns' => 3
    ];

    protected $options = [

        'portfolioColumns' => [
            ['value' => '2'],
            ['value' => '3'],
            ['value' => '4'],
        ],

    ];

}
