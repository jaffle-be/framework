<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemeContact extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $defaults = [
        'contactLayout'    => 'contact-1',
        'contactMainTitle' => [
            'nl' => "Contacteer ons",
            'en' => "Contact us",
        ],
        'contactContactTitle' => [
            'nl' => "Zeg eens hallo",
            'en' => "Get in touch",
        ],
        'contactHoursTitle' => [
            'nl' => "Wanneer zijn wij bereikbaar",
            'en' => "Hmmm, when are we available",
        ],
        'contactWidgetTitle' => [
            'nl' => "Waarom van je laten horen",
            'en' => "Why you should get in touch",
        ],
        'contactWidgetText' => [
            'nl' => "We doen meer dan je initieel zou denken. Helaas kunnen we onze site niet constant updaten, want er moet ook gewerkt worden aan zaken die ons klanten vooruithelpen.",
            'en' => "We offer more then you think, we can hardly put all our productions up here, or we'd be out of time actually doing things that matter.
Not sure if we could help you? Please, by all means, do not hesitate to ask",
        ],
        'contactFormTitle' => [
            'nl' => "Dus je zou echt iets willen zeggen",
            'en' => "So you got something to say",
        ],
        'contactFormText' => [
            'nl' => "Kan je het to the point houden? Zo blijft het tof en snel voor jij en ons team. Zo kunnen we ook makkelijker iedereen een antwoord geven.",
            'en' => "To keep things fast and fun for both you and our team, please get to the point quickly",
        ],
    ];

    protected $settings = [

        [
            'key' => 'contactLayout',
            'type' => 'select',
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
            'key' => 'contactMainTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'contact main title',
                'explanation' => 'contact main title'
            ],
            'fr'   => [
                'name'        => 'contact main title',
                'explanation' => 'contact main title'
            ],
            'de'   => [
                'name'        => 'contact main title',
                'explanation' => 'contact main title'
            ],
            'en'   => [
                'name'        => 'contact main title',
                'explanation' => 'contact main title'
            ],
        ],

        [
            'key' => 'contactContactTitle',
            'type' => 'string',
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
            'type' => 'string',
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
            'type' => 'string',
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
            'type' => 'text',
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
            'type' => 'string',
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
            'type' => 'text',
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
