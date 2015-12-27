<?php

namespace Modules\Theme;

use Illuminate\Database\Migrations\Migration;

/**
 * Class ThemeSettingMigration
 * @package Modules\Theme
 */
class ThemeSettingMigration extends Migration
{
    use MigrateThemeSettings;

    protected $name;

    protected $version = '1.0';

    protected $settings = [];

    protected $options = [];

    protected $defaults = [];

    public function up()
    {
        $theme = Theme::where('name', $this->name)
            ->where('version', $this->version)
            ->first();

        if (! $theme) {
            throw new Exception('Invalid theme provided');
        }

        $this->settings($theme);
    }

    public function down()
    {
        ThemeSetting::whereIn('key', $this->settingKeys())
            ->delete();
    }
}
