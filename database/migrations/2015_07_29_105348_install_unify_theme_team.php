<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemeTeam extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $settings = [


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

    ];

    protected $defaults = [
        'teamOverview'     => 'team-1',
        'teamDetail'       => 'member-1',
    ];

    protected $options = [

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

    ];

}
