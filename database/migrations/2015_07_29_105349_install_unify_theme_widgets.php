<?php

use Modules\Theme\ThemeSettingMigration;

class InstallUnifyThemeWidgets extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $defaults = [
        'widgetsOurClientsTitle'           => [
            'nl' => "Wie je reeds voorging",
            'en' => "These people put their trust in us",
        ],

        'widgetsCallToActionTitle'         => [
            'nl' => 'Nieuwe website nodig? Nieuwe content nodig?',
            'en' => 'Need a new website? Or better content?'
        ],
        'widgetsCallToActionText'          => [
            'nl' => 'Als je met ons in zee gaat, doen wij het nodige om aan je eisen te voldoen. Bovendien doen we meestal net dat beetje extra, waardoor het eindresultaat beter is dan de oorspronkelijke verwachtingen',
            'en' => 'You should really work with us. We always take care of our clients and make their business requirements our number one priority'
        ],
        'widgetsCallToActionButton'        => [
            'nl' => 'Eindelijk!',
            'en' => 'Finally!'
        ],
        'widgetsPortfolioTitle'            => [
            'nl' => 'Enkele van onze laatste werken',
            'en' => 'Some of our latest works'
        ],
        'widgetsPortfolioIntro'            => [
            'nl' => 'Stuk voor stuk worden projecten met de nodige zorg en stiptheid aan de klant afgeleverd. Hieronder zie je enkele resultaten van mensen die elk door hun passie uit te voeren samen werken aan een compleet project',
            'en' => 'Each project will be handled with extreme care and deadlines will be met 99% of the time. Below you can see some of the results our team of passionate people created'
        ],
        'widgetsPortfolioSeeAll'            => [
            'nl' => 'Bekijk alle projecten',
            'en' => 'See all projects'
        ],
        'widgetsRecentPostsTitle'          => [
            'nl' => 'We schrijven ook af en toe iets',
            'en' => 'We also like to write down our thoughts'
        ],
        'widgetsRecentPostsIntro'          => [
            'nl' => 'Soms moeten we iets neerpennen om een bepaald onderwerp beter te vatten. Hierbij proberen we deze bedenkingen online te delen zodat anderen kunnen leren uit onze ervaringen.',
            'en' => 'Sometimes we need to write something down, before we can actually grasp the subject. Sometimes our mind just needs some way of ordering all that information. We decided to put these thoughts online, so everyone could learn from the mistakes we made or the results we achieved.'
        ],
        'widgetsServicesMediaMainTitle' => [
            'nl' => 'Eigenschappen',
            'en' => 'Features',
        ],
        'widgetsServicesMediaTitle1'       => [
            'nl' => 'eigenschap 1',
            'en' => 'feature 1'
        ],
        'widgetsServicesMediaText1'        => [
            'nl' => 'alles over wat eigenschap 1 betekent',
            'en' => 'everything about what feature 1 can do'
        ],
        'widgetsServicesMediaTitle2'       => [
            'nl' => 'eigenschap 2',
            'en' => 'feature 2'
        ],
        'widgetsServicesMediaText2'        => [
            'nl' => 'alles over wat eigenschap 2 betekent',
            'en' => 'everything about what feature 2 can do'
        ],
        'widgetsServicesMediaTitle3'       => [
            'nl' => 'eigenschap 3',
            'en' => 'feature 3'
        ],
        'widgetsServicesMediaText3'        => [
            'nl' => 'alles over wat eigenschap 3 betekent',
            'en' => 'everything about what feature 3 can do'
        ],
        'widgetsServicesNotesTitle1'       => [
            'nl' => 'dienst 1',
            'en' => 'service 1'
        ],
        'widgetsServicesNotesText1'        => [
            'nl' => 'alles over wat dienst 1 betekent',
            'en' => 'everything about what service 1 means'
        ],
        'widgetsServicesNotesTitle2'       => [
            'nl' => 'dienst 2',
            'en' => 'service 2'
        ],
        'widgetsServicesNotesText2'        => [
            'nl' => 'alles over wat dienst 2 betekent',
            'en' => 'everything about what service 2 means'
        ],
        'widgetsServicesNotesTitle3'       => [
            'nl' => 'dienst 3',
            'en' => 'service 3'
        ],
        'widgetsServicesNotesText3'        => [
            'nl' => 'alles over wat dienst 3 betekent',
            'en' => 'everything about what service 3 means'
        ],
        'widgetsServicesOverviewMainTitle' => [
            'nl' => 'Hier vind je alles over onze diensten',
            'en' => 'everything you should know about our services'
        ],
        'widgetsServicesOverviewIntro'     => [
            'nl' => 'Wanneer je met ons samenwerkt, kan je altijd van volgende zaken zeker zijn',
            'en' => 'If you work with us, rest assured, our services always include the following'
        ],
        'widgetsServicesOverviewSubTitle1' => [
            'nl' => 'vanzelfsprekende dienst 1',
            'en' => 'common service 1'
        ],
        'widgetsServicesOverviewSubText1'  => [
            'nl' => 'alles wat vanzelfsprekende dienst 1 betekent',
            'en' => 'everything about this very common service 1'
        ],
        'widgetsServicesOverviewSubTitle2' => [
            'nl' => 'vanzelfsprekende dienst 2',
            'en' => 'common service 2'
        ],
        'widgetsServicesOverviewSubText2'  => [
            'nl' => 'alles wat vanzelfsprekende dienst 2 betekent',
            'en' => 'everything about this very common service 2'
        ],'widgetsServicesOverviewSubTitle3' => [
            'nl' => 'vanzelfsprekende dienst 3',
            'en' => 'common service 3'
        ],
        'widgetsServicesOverviewSubText3'  => [
            'nl' => 'alles wat vanzelfsprekende dienst 3 betekent',
            'en' => 'everything about this very common service 3'
        ],
        'widgetsTestimonialsTitle1'        => [
            'nl' => 'Project 1 was echt top',
            'en' => 'Project 1 was amazing'
        ],
        'widgetsTestimonialsText1'         => [
            'nl' => 'Ze hebben hun job echt zo goed gedaan voor ons project 1',
            'en' => 'They really pushed themselves for this project 1'
        ],
        'widgetsTestimonialsName1' => [
            'nl' => 'Johny',
            'en' => 'Johny',
        ],
        'widgetsTestimonialsFunction1'      => [
            'nl' => 'zotte functie (CEO)',
            'en' => 'crazy function (CEO)'
        ],
        'widgetsTestimonialsTitle2'        => [
            'nl' => 'Project 2 was echt top',
            'en' => 'Project 2 was amazing'
        ],
        'widgetsTestimonialsText2'         => [
            'nl' => 'Ze hebben hun job echt zo goed gedaan voor ons project 2',
            'en' => 'They really pushed themselves for this project 2'
        ],
        'widgetsTestimonialsName2' => [
            'nl' => 'Johny',
            'en' => 'Johny',
        ],
        'widgetsTestimonialsFunction2'      => [
            'nl' => 'zotte functie (CEO)',
            'en' => 'crazy function (CEO)'
        ],
        'widgetsTestimonialsTitle3'        => [
            'nl' => 'Project 3 was echt top',
            'en' => 'Project 3 was amazing'
        ],
        'widgetsTestimonialsText3'         => [
            'nl' => 'Ze hebben hun job echt zo goed gedaan voor ons project 3',
            'en' => 'They really pushed themselves for this project 3'
        ],
        'widgetsTestimonialsName3' => [
            'nl' => 'Johny',
            'en' => 'Johny',
        ],
        'widgetsTestimonialsFunction3'      => [
            'nl' => 'zotte functie (CEO)',
            'en' => 'crazy function (CEO)'
        ],
        'widgetsCalloutTitle'      => [
            'nl' => 'Nog vragen? Je wil erin vliegen?',
            'en' => 'Still have questions? Want to start?'
        ],
        'widgetsCalloutButton'      => [
            'nl' => 'Laat het weten',
            'en' => 'Let us know'
        ],


    ];

    protected $settings = [

        [
            'key'  => 'widgetsOurClientsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
            'en'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
            'de'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
            'fr'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
        ],

        [
            'key' => 'widgetsCallToActionTitle',
            'type' => 'string',
            'nl' => [
                'name' => 'call to action title',
                'description' => 'call to action title',
            ],
            'en' => [
                'name' => 'call to action title',
                'description' => 'call to action title',
            ],
        ],
        [
            'key' => 'widgetsCallToActionText',
            'type' => 'text',
            'nl' => [
                'name' => 'call to action text',
                'description' => 'call to action text',
            ],
            'en' => [
                'name' => 'call to action text',
                'description' => 'call to action text',
            ],
        ],
        [
            'key' => 'widgetsCallToActionButton',
            'type' => 'string',
            'nl' => [
                'name' => 'call to action button',
                'description' => 'call to action button',
            ],
            'en' => [
                'name' => 'call to action button',
                'description' => 'call to action button',
            ],
        ],
        [
            'key' => 'widgetsPortfolioTitle',
            'type' => 'string',
            'nl' => [
                'name' => 'portfolio title',
                'description' => 'portfolio title',
            ],
            'en' => [
                'name' => 'portfolio title',
                'description' => 'portfolio title',
            ],
        ],
        [
            'key' => 'widgetsPortfolioIntro',
            'type' => 'text',
            'nl' => [
                'name' => 'portfolio intro',
                'description' => 'portfolio intro',
            ],
            'en' => [
                'name' => 'portfolio intro',
                'description' => 'portfolio intro',
            ],
        ],
        [
            'key' => 'widgetsPortfolioSeeAll',
            'type' => 'text',
            'nl' => [
                'name' => 'portfolio see all',
                'description' => 'portfolio see all',
            ],
            'en' => [
                'name' => 'portfolio see all',
                'description' => 'portfolio see all',
            ],
        ],
        [
            'key' => 'widgetsRecentPostsTitle',
            'type' => 'string',
            'nl' => [
                'name' => 'recent posts title',
                'description' => 'recent posts title',
            ],
            'en' => [
                'name' => 'recent posts title',
                'description' => 'recent posts title',
            ],
        ],
        [
            'key' => 'widgetsRecentPostsIntro',
            'type' => 'text',
            'nl' => [
                'name' => 'recent posts intro',
                'description' => 'recent posts intro',
            ],
            'en' => [
                'name' => 'recent posts intro',
                'description' => 'recent posts intro',
            ],
        ],

        [
            'key' => 'widgetsServicesMediaMainTitle',
            'type' => 'string',
            'nl' => [
                'name' => 'services media main title',
                'description' => 'services media main title',
            ],
            'en' => [
                'name' => 'services media main title',
                'description' => 'services media main title',
            ],
        ],
        [
            'key' => 'widgetsServicesMediaTitle1',
            'type' => 'string',
            'nl' => [
                'name' => 'services media title 1',
                'description' => 'services media title 1',
            ],
            'en' => [
                'name' => 'services media title 1',
                'description' => 'services media title 1',
            ],
        ],
        [
            'key' => 'widgetsServicesMediaText1',
            'type' => 'text',
            'nl' => [
                'name' => 'services media text 1',
                'description' => 'services media text 1',
            ],
            'en' => [
                'name' => 'services media text 1',
                'description' => 'services media text 1',
            ],
        ],
        [
            'key' => 'widgetsServicesMediaTitle2',
            'type' => 'string',
            'nl' => [
                'name' => 'services media title 2',
                'description' => 'services media title 2',
            ],
            'en' => [
                'name' => 'services media title 2',
                'description' => 'services media title 2',
            ],
        ],
        [
            'key' => 'widgetsServicesMediaText2',
            'type' => 'text',
            'nl' => [
                'name' => 'services media text 2',
                'description' => 'services media text 2',
            ],
            'en' => [
                'name' => 'services media text 2',
                'description' => 'services media text 2',
            ],
        ],
        [
            'key' => 'widgetsServicesMediaTitle3',
            'type' => 'string',
            'nl' => [
                'name' => 'services media title 3',
                'description' => 'services media title 3',
            ],
            'en' => [
                'name' => 'services media title 3',
                'description' => 'services media title 3',
            ],
        ],
        [
            'key' => 'widgetsServicesMediaText3',
            'type' => 'text',
            'nl' => [
                'name' => 'services media text 3',
                'description' => 'services media text 3',
            ],
            'en' => [
                'name' => 'services media text 3',
                'description' => 'services media text 3',
            ],
        ],
        [
            'key' => 'widgetsServicesNotesTitle1',
            'type' => 'string',
            'nl' => [
                'name' => 'services notes title 1',
                'description' => 'services notes title 1',
            ],
            'en' => [
                'name' => 'services notes title 1',
                'description' => 'services notes title 1',
            ],
        ],
        [
            'key' => 'widgetsServicesNotesText1',
            'type' => 'text',
            'nl' => [
                'name' => 'services notes text 1',
                'description' => 'services notes text 1',
            ],
            'en' => [
                'name' => 'services notes text 1',
                'description' => 'services notes text 1',
            ],
        ],
        [
            'key' => 'widgetsServicesNotesTitle2',
            'type' => 'string',
            'nl' => [
                'name' => 'services notes title 2',
                'description' => 'services notes title 2',
            ],
            'en' => [
                'name' => 'services notes title 2',
                'description' => 'services notes title 2',
            ],
        ],
        [
            'key' => 'widgetsServicesNotesText2',
            'type' => 'text',
            'nl' => [
                'name' => 'services notes text 2',
                'description' => 'services notes text 2',
            ],
            'en' => [
                'name' => 'services notes text 2',
                'description' => 'services notes text 2',
            ],
        ],
        [
            'key' => 'widgetsServicesNotesTitle3',
            'type' => 'string',
            'nl' => [
                'name' => 'services notes title 3',
                'description' => 'services notes title 3',
            ],
            'en' => [
                'name' => 'services notes title 3',
                'description' => 'services notes title 3',
            ],
        ],
        [
            'key' => 'widgetsServicesNotesText3',
            'type' => 'text',
            'nl' => [
                'name' => 'services notes text 3',
                'description' => 'services notes text 3',
            ],
            'en' => [
                'name' => 'services notes text 3',
                'description' => 'services notes text 3',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewMainTitle',
            'type' => 'string',
            'nl' => [
                'name' => 'services overview main title',
                'description' => 'services overview main title',
            ],
            'en' => [
                'name' => 'services overview main title',
                'description' => 'services overview main title',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewIntro',
            'type' => 'text',
            'nl' => [
                'name' => 'services overview intro',
                'description' => 'services overview intro',
            ],
            'en' => [
                'name' => 'services overview intro',
                'description' => 'services overview intro',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewSubTitle1',
            'type' => 'string',
            'nl' => [
                'name' => 'services overview subtitle 1',
                'description' => 'services overview subtitle 1',
            ],
            'en' => [
                'name' => 'services overview subtitle 1',
                'description' => 'services overview subtitle 1',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewSubText1',
            'type' => 'text',
            'nl' => [
                'name' => 'services overview subtext 1',
                'description' => 'services overview subtext 1',
            ],
            'en' => [
                'name' => 'services overview subtext 1',
                'description' => 'services overview subtext 1',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewSubTitle2',
            'type' => 'string',
            'nl' => [
                'name' => 'services overview subtitle 2',
                'description' => 'services overview subtitle 2',
            ],
            'en' => [
                'name' => 'services overview subtitle 2',
                'description' => 'services overview subtitle 2',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewSubText2',
            'type' => 'text',
            'nl' => [
                'name' => 'services overview subtext 2',
                'description' => 'services overview subtext 2',
            ],
            'en' => [
                'name' => 'services overview subtext 2',
                'description' => 'services overview subtext 2',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewSubTitle3',
            'type' => 'string',
            'nl' => [
                'name' => 'services overview subtitle 3',
                'description' => 'services overview subtitle 3',
            ],
            'en' => [
                'name' => 'services overview subtitle 3',
                'description' => 'services overview subtitle 3',
            ],
        ],
        [
            'key' => 'widgetsServicesOverviewSubText3',
            'type' => 'text',
            'nl' => [
                'name' => 'services overview subtext 3',
                'description' => 'services overview subtext 3',
            ],
            'en' => [
                'name' => 'services overview subtext 3',
                'description' => 'services overview subtext 3',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsTitle1',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial title 1',
                'description' => 'testimonial title 1',
            ],
            'en' => [
                'name' => 'testimonial title 1',
                'description' => 'testimonial title 1',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsText1',
            'type' => 'text',
            'nl' => [
                'name' => 'testimonial text 1',
                'description' => 'testimonial text 1',
            ],
            'en' => [
                'name' => 'testimonial text 1',
                'description' => 'testimonial text 1',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsName1',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial name 1',
                'description' => 'testimonial name 1',
            ],
            'en' => [
                'name' => 'testimonial name 1',
                'description' => 'testimonial name 1',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsFunction1',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial function 1',
                'description' => 'testimonial function 1',
            ],
            'en' => [
                'name' => 'testimonial function 1',
                'description' => 'testimonial function 1',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsTitle2',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial title 2',
                'description' => 'testimonial title 2',
            ],
            'en' => [
                'name' => 'testimonial title 2',
                'description' => 'testimonial title 2',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsText2',
            'type' => 'text',
            'nl' => [
                'name' => 'testimonial text 2',
                'description' => 'testimonial text 2',
            ],
            'en' => [
                'name' => 'testimonial text 2',
                'description' => 'testimonial text 2',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsName2',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial name 2',
                'description' => 'testimonial name 2',
            ],
            'en' => [
                'name' => 'testimonial name 2',
                'description' => 'testimonial name 2',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsFunction2',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial function 2',
                'description' => 'testimonial function 2',
            ],
            'en' => [
                'name' => 'testimonial function 2',
                'description' => 'testimonial function 2',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsTitle3',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial title 2',
                'description' => 'testimonial title 2',
            ],
            'en' => [
                'name' => 'testimonial title 2',
                'description' => 'testimonial title 2',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsText3',
            'type' => 'text',
            'nl' => [
                'name' => 'testimonial text 2',
                'description' => 'testimonial text 2',
            ],
            'en' => [
                'name' => 'testimonial text 2',
                'description' => 'testimonial text 2',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsName3',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial name 3',
                'description' => 'testimonial name 3',
            ],
            'en' => [
                'name' => 'testimonial name 3',
                'description' => 'testimonial name 3',
            ],
        ],
        [
            'key' => 'widgetsTestimonialsFunction3',
            'type' => 'string',
            'nl' => [
                'name' => 'testimonial function 2',
                'description' => 'testimonial function 2',
            ],
            'en' => [
                'name' => 'testimonial function 2',
                'description' => 'testimonial function 2',
            ],
        ],
        [
            'key' => 'widgetsCalloutTitle',
            'type' => 'string',
            'nl' => [
                'name' => 'callout title',
                'description' => 'callout title',
            ],
            'en' => [
                'name' => 'callout title',
                'description' => 'callout title',
            ],
        ],
        [
            'key' => 'widgetsCalloutButton',
            'type' => 'string',
            'nl' => [
                'name' => 'callout button',
                'description' => 'callout button',
            ],
            'en' => [
                'name' => 'callout button',
                'description' => 'callout button',
            ],
        ],

    ];

    protected $options = [

    ];

}
