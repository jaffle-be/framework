<?php

use App\Theme\ThemeSettingDefault;
use Illuminate\Database\Migrations\Migration;

class InstallUnifyTheme extends Migration
{

    protected $name = 'unify';

    protected $version = '1.0';

    protected $settings = [

        [
            'key' => 'header',
            'nl'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'fr'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'de'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
            'en'  => [
                'name'        => 'header view',
                'explanation' => 'header view'
            ],
        ],

        [
            'key' => 'footer',
            'nl'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'fr'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'de'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
            'en'  => [
                'name'        => 'footer view',
                'explanation' => 'footer view'
            ],
        ],];

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
        ]

    ];

    protected $defaults = [
        'header' => 'header_default',
        'footer' => 'footer_default',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $theme = App\Theme\Theme::create([
            'name'    => $this->name,
            'version' => $this->version,
        ]);

        foreach ($this->settings as $setting) {

            $setting = $theme->settings()->create($setting);

            $options = $this->options[$setting->key];

            foreach ($options as $option) {
                $setting->options()->create($option);
            }

            if(isset($this->defaults[$setting->key]))
            {
                $option = $setting->options()->where('value', $this->defaults[$setting->key])->first();

                $setting->defaults()->create(['option_id' => $option->id]);
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $theme = App\Theme\Theme::where('name', $this->name)->first();

        if ($theme) {
            $theme->delete();
        }
    }
}
