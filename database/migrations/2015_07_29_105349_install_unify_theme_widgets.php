<?php

use App\Theme\ThemeSettingMigration;

class InstallUnifyThemeWidgets extends ThemeSettingMigration
{

    protected $name = 'Unify';

    protected $version = '1.0';

    protected $settings = [

        [
            'key'  => 'widgetOurClientsTitle',
            'type' => 'string',
            'nl'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
            'fr'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
            'de'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
            'en'   => [
                'name'        => 'widgetOurClientsTitle',
                'explanation' => 'widgetOurClientsTitle'
            ],
        ],
    ];

    protected $defaults = [

    ];

    protected $options = [

    ];

}
