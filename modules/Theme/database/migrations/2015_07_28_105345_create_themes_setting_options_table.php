<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateThemesSettingOptionsTable
 */
class CreateThemesSettingOptionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('themes_setting_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('key_id', false, true);
            $table->foreign('key_id', 'theme_setting_options_to_keys')->references('id')->on('themes_setting_keys')->onDelete('cascade');
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('themes_setting_option_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_id', false, true);
            $table->foreign('option_id', 'translations_to_theme_setting_options')->references('id')->on('themes_setting_options')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->string('explanation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('themes_setting_option_translations', function (Blueprint $table) {
            $table->dropForeign('translations_to_theme_setting_options');
        });

        Schema::drop('themes_setting_options', function (Blueprint $table) {
            $table->dropForeign('theme_setting_options_to_keys');
        });
    }
}
