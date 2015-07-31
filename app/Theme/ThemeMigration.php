<?php namespace App\Theme;

use Illuminate\Database\Migrations\Migration;

class ThemeMigration extends Migration
{

    protected $name;

    protected $version = '1.0';

    protected $settings = [];

    protected $options = [];

    protected $defaults = [];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $theme = Theme::create([
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
        $theme = Theme::where('name', $this->name)->first();

        if ($theme) {
            $theme->delete();
        }
    }

}