<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemeBlog extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $defaults = [
        'blogOverview'     => 'masonry',
        'blogDetail'       => 'full-width/large-detail',
        'blogMainTitleOverview' => [
            'en' => "What happens at digiredo, stays at digiredo",
            'nl' => "Wat er bij ons gebeurt"
        ],
        'blogMainTitleDetail' => [
            'en' => "This one was particularly special",
            'nl' => "Nieuws"
        ],
        'blogSidebarRecentPostsTitle' => [
            'en' => 'Recent posts',
            'nl' => 'Laatste nieuws',
        ],
        'blogSidebarSocialLinksTitle' => [
            'en' => 'Get social',
            'nl' => 'Doe sociaal',
        ],
        'blogSidebarTagsTitle' => [
            'en' => 'Take a peek',
            'nl' => 'Neem een kijkje',
        ]
    ];

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

        [
            'key' => 'blogMainTitleOverview',
            'type' => 'string',
            'nl'   => [
                'name'        => 'blog main title overview',
                'explanation' => 'blog main title overview'
            ],
            'fr'   => [
                'name'        => 'blog main title overview',
                'explanation' => 'blog main title overview'
            ],
            'de'   => [
                'name'        => 'blog main title overview',
                'explanation' => 'blog main title overview'
            ],
            'en'   => [
                'name'        => 'blog main title overview',
                'explanation' => 'blog main title overview'
            ],
        ],

        [
            'key' => 'blogMainTitleDetail',
            'type' => 'string',
            'nl'   => [
                'name'        => 'blog main title detail',
                'explanation' => 'blog main title detail'
            ],
            'fr'   => [
                'name'        => 'blog main title detail',
                'explanation' => 'blog main title detail'
            ],
            'de'   => [
                'name'        => 'blog main title detail',
                'explanation' => 'blog main title detail'
            ],
            'en'   => [
                'name'        => 'blog main title detail',
                'explanation' => 'blog main title detail'
            ],
        ],

        [
            'key' => 'blogSidebarRecentPostsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'recent posts sidebar title',
                'explanation' => 'recent posts sidebar title'
            ],
            'fr'   => [
                'name'        => 'recent posts sidebar title',
                'explanation' => 'recent posts sidebar title'
            ],
            'de'   => [
                'name'        => 'recent posts sidebar title',
                'explanation' => 'recent posts sidebar title'
            ],
            'en'   => [
                'name'        => 'recent posts sidebar title',
                'explanation' => 'recent posts sidebar title'
            ],
        ],

        [
            'key' => 'blogSidebarSocialLinksTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'blog social links sidebar title',
                'explanation' => 'blog social links sidebar title'
            ],
            'fr'   => [
                'name'        => 'blog social links sidebar title',
                'explanation' => 'blog social links sidebar title'
            ],
            'de'   => [
                'name'        => 'blog social links sidebar title',
                'explanation' => 'blog social links sidebar title'
            ],
            'en'   => [
                'name'        => 'blog social links sidebar title',
                'explanation' => 'blog social links sidebar title'
            ],
        ],

        [
            'key' => 'blogSidebarTagsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'blog tags sidebar title',
                'explanation' => 'blog tags sidebar title'
            ],
            'fr'   => [
                'name'        => 'blog tags sidebar title',
                'explanation' => 'blog tags sidebar title'
            ],
            'de'   => [
                'name'        => 'blog tags sidebar title',
                'explanation' => 'blog tags sidebar title'
            ],
            'en'   => [
                'name'        => 'blog tags sidebar title',
                'explanation' => 'blog tags sidebar title'
            ],
        ],

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
