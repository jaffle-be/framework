<?php

use Modules\Theme\ThemeSettingMigration;

class InstallUnifyThemeTeam extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $defaults = [
        'teamOverview' => 'team-1',
        'teamDetail'   => 'member-1',
        'teamAboutTitle' => [
            'nl' => "Dit zijn wij",
            'en' => "Yes we can",
        ],
        'teamAboutMemberMainTitle' => [
            'nl' => "Deze collega staat voor je klaar",
            'en' => "This person will jump to get your things done",
        ],
        'teamMemberAboutTitle' => [
            'nl' => "Wat zij/hij effectief doet",
            'en' => "What she/he actually does",
        ],
        'teamMemberSkillsTitle' => [
            'nl' => "Een greep uit de sterktes",
            'en' => "A sneak peek on the skills",
        ],
        'teamMemberPortfolioTitle' => [
            'nl' => "Meegewerkt aan",
            'en' => "Helped with",
        ],
        'teamMemberPortfolioText' => [
            'nl' => "Iedereen bij ons kan plots meewerken aan een specifiek project. Iedereen doet enkel waar hij goed in is en daar proberen we ons echt aan te houden.",
            'en' => "All our team members are able to suddenly jump in on a project and help out. Why? We are pretty peculiar about letting people only do what they were born to do.",
        ],
        'teamMemberMyPosts' => [
            'nl' => "Wat ik allemaal geschreven heb",
            'en' => "This is what I wrote",
        ],
        'teamMemberCounterLabel1' => [
            'nl' => "Koffie",
            'en' => "Coffees",
        ],
        'teamMemberCounterLabel2' => [
            'nl' => "Bier",
            'en' => "Beers",
        ],
        'teamMemberCounterLabel3' => [
            'nl' => "Fastfood",
            'en' => "Fastfood",
        ],
        'teamMemberCounterLabel4' => [
            'nl' => "Water",
            'en' => "Water",
        ],
        'teamHiringTitle' => [
            'nl' => "Wil je met ons samenwerken",
            'en' => "Want to work with us",
        ],
        'teamHiringText' => [
            'nl' => "Neem gerust contact op en laat van je horen. We kunnen altijd extra mensen gebruiken.",
            'en' => "Get in touch as we can always use an extra hand or skill.",
        ],
        'teamHiringButton' => [
            'nl' => "Goed idee",
            'en' => "Sounds nice",
        ],
        'teamHireMeText' => [
            'nl' => "Je wil beroep doen op mijn diensten? Of je twijfelt of ik je kan helpen?",
            'en' => "You would like me to help you with a job? Or you're not sure if I could help you?",
        ],
        'teamHireMeButton' => [
            'nl' => "Geef een seintje",
            'en' => "Get in touch",
        ],
    ];

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
            'key' => 'teamHiringTitle',
            'type' => 'string',
            'nl' => [
                'name' => "Wil je met ons samenwerken",
                'description' => "Wil je met ons samenwerken",
            ],
            'en' => [
                'name' => "Want to work with us",
                'description' => "Want to work with us",
            ],
        ],
        [
            'key' => 'teamHiringText',
            'type' => 'string',
            'nl' => [
                'name' => "Neem gerust contact op en laat van je horen. We kunnen altijd extra mensen gebruiken.",
                'description' => "Neem gerust contact op en laat van je horen. We kunnen altijd extra mensen gebruiken.",
            ],
            'en' => [
                'name' => "Get in touch as we can always use an extra hand or skill.",
                'description' => "Get in touch as we can always use an extra hand or skill.",
            ],
        ],
        [
            'key' => 'teamHiringButton',
            'type' => 'string',
            'nl' => [
                'name' => "Goed idee",
                'description' => "Goed idee",
            ],
            'en' => [
                'name' => "Sounds nice",
                'description' => "Sounds nice",
            ],
        ],
        [
            'key' => 'teamHireMeText',
            'type' => 'string',
            'nl' => [
                'name' => "Je wil beroep doen op mijn diensten? Of je twijfelt of ik je kan helpen?",
                'description' => "Je wil beroep doen op mijn diensten? Of je twijfelt of ik je kan helpen?",
            ],
            'en' => [
                'name' => "You would like me to help you with a job? Or you're not sure if I could help you?",
                'description' => "You would like me to help you with a job? Or you're not sure if I could help you?",
            ],
        ],
        [
            'key' => 'teamHireMeButton',
            'type' => 'string',
            'nl' => [
                'name' => "Geef een seintje",
                'description' => "Geef een seintje",
            ],
            'en' => [
                'name' => "Get in touch",
                'description' => "Get in touch",
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
            'key'  => 'teamMemberMyPosts',
            'type' => 'string',
            'nl'   => [
                'name'        => 'team member my posts',
                'explanation' => 'team member my posts'
            ],
            'fr'   => [
                'name'        => 'team member my posts',
                'explanation' => 'team member my posts'
            ],
            'de'   => [
                'name'        => 'team member my posts',
                'explanation' => 'team member my posts'
            ],
            'en'   => [
                'name'        => 'team member my posts',
                'explanation' => 'team member my posts'
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
