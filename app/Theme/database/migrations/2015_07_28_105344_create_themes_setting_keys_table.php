<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesSettingKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes_setting_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('theme_id', false, true);
            $table->foreign('theme_id', 'theme_setting_keys_to_theme')->references('id')->on('themes')->onDelete('cascade');
            
            $table->string('key');
            $table->timestamps();
        });

        Schema::create('themes_setting_key_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('key_id', false, true);
            $table->foreign('key_id', 'translations_to_theme_setting_keys')->references('id')->on('themes_setting_keys')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->string('explanation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('themes_setting_key_translations', function(Blueprint $table){
            $table->dropForeign('translations_to_theme_setting_keys');
        });

        Schema::drop('themes_setting_keys', function(Blueprint $table)
        {
            $table->dropForeign('theme_setting_keys_to_theme');
        });

    }
}
