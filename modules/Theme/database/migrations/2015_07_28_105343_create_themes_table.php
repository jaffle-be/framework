<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateThemesTable
 */
class CreateThemesTable extends Migration
{
    use \Modules\System\ConfigWriter;

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('version', 15);
            $table->timestamps();
        });

        $this->replaceConfigValue(config_path().'/system.php', 'installed', 'true');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->replaceConfigValue(config_path().'/system.php', 'installed', 'false');

        Schema::drop('themes');
    }
}
