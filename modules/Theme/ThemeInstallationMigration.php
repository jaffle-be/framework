<?php

namespace Modules\Theme;

use Illuminate\Database\Migrations\Migration;

/**
 * Class ThemeInstallationMigration
 * @package Modules\Theme
 */
class ThemeInstallationMigration extends Migration
{
    use MigrateThemeSettings;

    protected $name;

    protected $version = '1.0';

    protected $settings = [];

    protected $options = [];

    protected $defaults = [];

    /**
     * Run the migrations.
     */
    public function up()
    {
        $theme = Theme::create([
            'name' => $this->name,
            'version' => $this->version,
        ]);

        $this->settings($theme);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $theme = Theme::where('name', $this->name)->delete();
    }
}
