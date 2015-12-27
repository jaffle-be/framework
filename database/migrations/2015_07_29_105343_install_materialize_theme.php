<?php

use Modules\Theme\ThemeInstallationMigration;

class InstallMaterializeTheme extends ThemeInstallationMigration
{
    protected $name = 'Materialize';

    protected $settings = [

        [
            'key' => 'header',
            'type' => 'select',
            'nl'  => [
                'name'        => 'header view',
                'explanation' => 'header view',
            ],
            'fr'  => [
                'name'        => 'header view',
                'explanation' => 'header view',
            ],
            'de'  => [
                'name'        => 'header view',
                'explanation' => 'header view',
            ],
            'en'  => [
                'name'        => 'header view',
                'explanation' => 'header view',
            ],
        ],

        [
            'key' => 'footer',
            'type' => 'select',
            'nl'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view',
            ],
            'fr'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view',
            ],
            'de'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view',
            ],
            'en'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view',
            ],
        ],
    ];

    protected $options = [

        'header' => [

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

        'footer' => [
            ['value' => 'footer_default'],
            ['value' => 'footer_v1'],
            ['value' => 'footer_v2'],
            ['value' => 'footer_v3'],
            ['value' => 'footer_v4'],
            ['value' => 'footer_v5'],
            ['value' => 'footer_v6'],
            ['value' => 'footer_v7'],
        ],

    ];
}
