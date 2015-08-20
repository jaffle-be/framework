<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemeTeam extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $settings = [

        [
            'key'  => 'teamOverview',
            'type' => 'select',
            'nl'   => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
            'fr'   => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
            'de'   => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
            'en'   => [
                'name'        => 'team overview layout',
                'explanation' => 'team overview layout'
            ],
        ],

        [
            'key'  => 'teamDetail',
            'type' => 'select',
            'nl'   => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
            'fr'   => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
            'de'   => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
            'en'   => [
                'name'        => 'team detail layout',
                'explanation' => 'team detail layout'
            ],
        ],

        [
            'key'  => 'teamHiring',
            'type' => 'boolean',
            'nl'   => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
            'fr'   => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
            'de'   => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
            'en'   => [
                'name'        => 'team is hiring',
                'explanation' => 'team is hiring'
            ],
        ],

        [
            'key'  => 'teamHireMe',
            'type' => 'boolean',
            'nl'   => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
            'fr'   => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
            'de'   => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
            'en'   => [
                'name'        => 'you can hire me',
                'explanation' => 'you can hire me'
            ],
        ],

        [
            'key'  => 'teamLightQuote',
            'type' => 'boolean',
            'nl'   => [
                'name'        => 'team light quote parallax',
                'explanation' => 'team light quote parallax'
            ],
            'fr'   => [
                'name'        => 'team light quote parallax',
                'explanation' => 'team light quote parallax'
            ],
            'de'   => [
                'name'        => 'team light quote parallax',
                'explanation' => 'team light quote parallax'
            ],
            'en'   => [
                'name'        => 'team light quote parallax',
                'explanation' => 'team light quote parallax'
            ],
        ],

        [
            'key' => 'teamAboutTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team about title',
                'explanation' => 'team about title'
            ],
            'fr'   => [
                'name'        => 'team about title',
                'explanation' => 'team about title'
            ],
            'de'   => [
                'name'        => 'team about title',
                'explanation' => 'team about title'
            ],
            'en'   => [
                'name'        => 'team about title',
                'explanation' => 'team about title'
            ],
        ],

        [
            'key' => 'teamAboutMemberMainTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team about main title',
                'explanation' => 'team about main title'
            ],
            'fr'   => [
                'name'        => 'team about main title',
                'explanation' => 'team about main title'
            ],
            'de'   => [
                'name'        => 'team about main title',
                'explanation' => 'team about main title'
            ],
            'en'   => [
                'name'        => 'team about main title',
                'explanation' => 'team about main title'
            ],
        ],

        [
            'key'  => 'teamMemberAboutTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member about title',
                'explanation' => 'team member about title'
            ],
            'fr'   => [
                'name'        => 'team member about title',
                'explanation' => 'team member about title'
            ],
            'de'   => [
                'name'        => 'team member about title',
                'explanation' => 'team member about title'
            ],
            'en'   => [
                'name'        => 'team member about title',
                'explanation' => 'team member about title'
            ],
        ],

        [
            'key'  => 'teamMemberSkillsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member skills title',
                'explanation' => 'team member skills title'
            ],
            'fr'   => [
                'name'        => 'team member skills title',
                'explanation' => 'team member skills title'
            ],
            'de'   => [
                'name'        => 'team member skills title',
                'explanation' => 'team member skills title'
            ],
            'en'   => [
                'name'        => 'team member skills title',
                'explanation' => 'team member skills title'
            ],
        ],

        [
            'key'  => 'teamMemberPortfolioTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member portfolio title',
                'explanation' => 'team member portfolio title'
            ],
            'fr'   => [
                'name'        => 'team member portfolio title',
                'explanation' => 'team member portfolio title'
            ],
            'de'   => [
                'name'        => 'team member portfolio title',
                'explanation' => 'team member portfolio title'
            ],
            'en'   => [
                'name'        => 'team member portfolio title',
                'explanation' => 'team member portfolio title'
            ],
        ],

        [
            'key'  => 'teamMemberPortfolioText',
            'type' => 'text',
            'nl'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
            'fr'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
            'de'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
            'en'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
        ],

        [
            'key'  => 'teamMemberPortfolioText',
            'type' => 'text',
            'nl'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
            'fr'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
            'de'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
            'en'   => [
                'name'        => 'team member portfolio text',
                'explanation' => 'team member portfolio text'
            ],
        ],

        [
            'key'  => 'teamMemberCounterLabel1',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member counter label 1',
                'explanation' => 'team member counter label 1'
            ],
            'fr'   => [
                'name'        => 'team member counter label 1',
                'explanation' => 'team member counter label 1'
            ],
            'de'   => [
                'name'        => 'team member counter label 1',
                'explanation' => 'team member counter label 1'
            ],
            'en'   => [
                'name'        => 'team member counter label 1',
                'explanation' => 'team member counter label 1'
            ],
        ],

        [
            'key'  => 'teamMemberCounterLabel2',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member counter label 2',
                'explanation' => 'team member counter label 2'
            ],
            'fr'   => [
                'name'        => 'team member counter label 2',
                'explanation' => 'team member counter label 2'
            ],
            'de'   => [
                'name'        => 'team member counter label 2',
                'explanation' => 'team member counter label 2'
            ],
            'en'   => [
                'name'        => 'team member counter label 2',
                'explanation' => 'team member counter label 2'
            ],
        ],

        [
            'key'  => 'teamMemberCounterLabel3',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member counter label 3',
                'explanation' => 'team member counter label 3'
            ],
            'fr'   => [
                'name'        => 'team member counter label 3',
                'explanation' => 'team member counter label 3'
            ],
            'de'   => [
                'name'        => 'team member counter label 3',
                'explanation' => 'team member counter label 3'
            ],
            'en'   => [
                'name'        => 'team member counter label 3',
                'explanation' => 'team member counter label 3'
            ],
        ],

        [
            'key'  => 'teamMemberCounterLabel4',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member counter label 4',
                'explanation' => 'team member counter label 4'
            ],
            'fr'   => [
                'name'        => 'team member counter label 4',
                'explanation' => 'team member counter label 4'
            ],
            'de'   => [
                'name'        => 'team member counter label 4',
                'explanation' => 'team member counter label 4'
            ],
            'en'   => [
                'name'        => 'team member counter label 4',
                'explanation' => 'team member counter label 4'
            ],
        ],

        [
            'key'  => 'teamMemberCounterValue1',
            'type' => 'numeric',
            'nl'   => [
                'name'        => 'team member counter value 1',
                'explanation' => 'team member counter value 1'
            ],
            'fr'   => [
                'name'        => 'team member counter value 1',
                'explanation' => 'team member counter value 1'
            ],
            'de'   => [
                'name'        => 'team member counter value 1',
                'explanation' => 'team member counter value 1'
            ],
            'en'   => [
                'name'        => 'team member counter value 1',
                'explanation' => 'team member counter value 1'
            ],
        ],

        [
            'key'  => 'teamMemberCounterValue2',
            'type' => 'numeric',
            'nl'   => [
                'name'        => 'team member counter value 2',
                'explanation' => 'team member counter value 2'
            ],
            'fr'   => [
                'name'        => 'team member counter value 2',
                'explanation' => 'team member counter value 2'
            ],
            'de'   => [
                'name'        => 'team member counter value 2',
                'explanation' => 'team member counter value 2'
            ],
            'en'   => [
                'name'        => 'team member counter value 2',
                'explanation' => 'team member counter value 2'
            ],
        ],

        [
            'key'  => 'teamMemberCounterValue3',
            'type' => 'numeric',
            'nl'   => [
                'name'        => 'team member counter value 3',
                'explanation' => 'team member counter value 3'
            ],
            'fr'   => [
                'name'        => 'team member counter value 3',
                'explanation' => 'team member counter value 3'
            ],
            'de'   => [
                'name'        => 'team member counter value 3',
                'explanation' => 'team member counter value 3'
            ],
            'en'   => [
                'name'        => 'team member counter value 3',
                'explanation' => 'team member counter value 3'
            ],
        ],

        [
            'key'  => 'teamMemberCounterValue4',
            'type' => 'numeric',
            'nl'   => [
                'name'        => 'team member counter value 4',
                'explanation' => 'team member counter value 4'
            ],
            'fr'   => [
                'name'        => 'team member counter value 4',
                'explanation' => 'team member counter value 4'
            ],
            'de'   => [
                'name'        => 'team member counter value 4',
                'explanation' => 'team member counter value 4'
            ],
            'en'   => [
                'name'        => 'team member counter value 4',
                'explanation' => 'team member counter value 4'
            ],
        ],
    ];

    protected $defaults = [
        'teamOverview' => 'team-1',
        'teamDetail'   => 'member-1',
    ];

    protected $options = [

        'teamOverview' => [
            ['value' => 'team-1'],
            ['value' => 'team-2'],
            ['value' => 'team-3'],
        ],

        'teamDetail'   => [
            ['value' => 'member-1'],
            ['value' => 'member-2'],
        ],

    ];

}
