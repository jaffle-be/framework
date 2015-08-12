<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemeContact extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $settings = [

        [
            'key' => 'contactLayout',
            'nl'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
            'fr'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
            'de'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
            'en'  => [
                'name'        => 'contact layout',
                'explanation' => 'contact layout'
            ],
        ],

        [
            'key' => 'contactContactTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'contact contact info title',
                'explanation' => 'contact contact info title'
            ],
            'fr'  => [
                'name'        => 'contact contact info title',
                'explanation' => 'contact contact info title'
            ],
            'de'  => [
                'name'        => 'contact contact info title',
                'explanation' => 'contact contact info title'
            ],
            'en'  => [
                'name'        => 'contact contact info title',
                'explanation' => 'contact contact info title'
            ],
        ],

        [
            'key' => 'contactHoursTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'contact openinghours title',
                'explanation' => 'contact openinghours title'
            ],
            'fr'  => [
                'name'        => 'contact openinghours title',
                'explanation' => 'contact openinghours title'
            ],
            'de'  => [
                'name'        => 'contact openinghours title',
                'explanation' => 'contact openinghours title'
            ],
            'en'  => [
                'name'        => 'contact openinghours title',
                'explanation' => 'contact openinghours title'
            ],
        ],


        [
            'key' => 'contactWidgetTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'contact widget title',
                'explanation' => 'contact widget title'
            ],
            'fr'  => [
                'name'        => 'contact widget title',
                'explanation' => 'contact widget title'
            ],
            'de'  => [
                'name'        => 'contact widget title',
                'explanation' => 'contact widget title'
            ],
            'en'  => [
                'name'        => 'contact widget title',
                'explanation' => 'contact widget title'
            ],
        ],

        [
            'key' => 'contactWidgetText',
            'text' => true,
            'nl'  => [
                'name'        => 'contact widget text',
                'explanation' => 'contact widget text'
            ],
            'fr'  => [
                'name'        => 'contact widget text',
                'explanation' => 'contact widget text'
            ],
            'de'  => [
                'name'        => 'contact widget text',
                'explanation' => 'contact widget text'
            ],
            'en'  => [
                'name'        => 'contact widget text',
                'explanation' => 'contact widget text'
            ],
        ],


        [
            'key' => 'contactFormTitle',
            'string' => true,
            'nl'  => [
                'name'        => 'contact form title',
                'explanation' => 'contact form title'
            ],
            'fr'  => [
                'name'        => 'contact form title',
                'explanation' => 'contact form title'
            ],
            'de'  => [
                'name'        => 'contact form title',
                'explanation' => 'contact form title'
            ],
            'en'  => [
                'name'        => 'contact form title',
                'explanation' => 'contact form title'
            ],
        ],

        [
            'key' => 'contactFormText',
            'text' => true,
            'nl'  => [
                'name'        => 'contact form text',
                'explanation' => 'contact form text'
            ],
            'fr'  => [
                'name'        => 'contact form text',
                'explanation' => 'contact form text'
            ],
            'de'  => [
                'name'        => 'contact form text',
                'explanation' => 'contact form text'
            ],
            'en'  => [
                'name'        => 'contact form text',
                'explanation' => 'contact form text'
            ],
        ],

    ];

    protected $defaults = [
        'contactLayout'    => 'contact-1',
    ];

    protected $options = [

        'contactLayout'    => [
            ['value' => 'contact-1'],
            ['value' => 'contact-2'],
            ['value' => 'contact-3'],
            ['value' => 'contact-4'],
            ['value' => 'contact-advanced'],
        ],
    ];

}
