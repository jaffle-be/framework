<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jaffle\Tools\ConfigWriter;

class CreateThemesTable extends Migration
{

    use ConfigWriter;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('version', 15);
            $table->timestamps();
        });

        $this->replaceConfigValue(config_path() . '/system.php', 'installed', 'true');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->replaceConfigValue(config_path() . '/system.php', 'installed', 'false');

        Schema::drop('themes');
    }

}
