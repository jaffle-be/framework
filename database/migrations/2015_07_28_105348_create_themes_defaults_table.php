<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesDefaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes_setting_defaults', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('key_id', false, true);
            $table->foreign('key_id', 'theme_setting_defaults_to_keys')->references('id')->on('themes_setting_keys')->onDelete('cascade');

            $table->integer('option_id', false, true)->nullable();
            $table->foreign('option_id', 'theme_setting_defaults_to_option')->references('id')->on('themes_setting_options')->onDelete('cascade');
            $table->timestamps();
        });;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('themes_setting_defaults', function(Blueprint $table)
        {
            $table->dropForeign('theme_setting_defaults_to_keys');
            $table->dropForeign('theme_setting_defaults_to_option');
        });
    }
}
