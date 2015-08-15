<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemeBlog extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $settings = [

        [
            'key' => 'blogOverview',
            'type' => 'select',
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
            'type' => 'select',
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
    ];

    protected $defaults = [
        'blogOverview'     => 'masonry',
        'blogDetail'       => 'full-width/large-detail',
    ];

    protected $options = [

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
    ];

}
