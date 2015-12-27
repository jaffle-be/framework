<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Theme\ThemeSettingType;

/**
 * Class CreateThemesSettingKeysTable
 */
class CreateThemesSettingKeysTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('themes_setting_key_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        $names = ['boolean', 'string', 'text', 'numeric', 'select'];

        foreach ($names as $name) {
            ThemeSettingType::create(['name' => $name]);
        }

        Schema::create('themes_setting_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id', false, true);
            $table->foreign('type_id', 'theme_setting_keys_to_key_type')->references('id')->on('themes_setting_key_types')->onDelete('cascade');
            $table->integer('theme_id', false, true);
            $table->foreign('theme_id', 'theme_setting_keys_to_theme')->references('id')->on('themes')->onDelete('cascade');
            $table->string('key');
            $table->timestamps();
        });

        Schema::create('themes_setting_key_translations', function (Blueprint $table) {
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
     */
    public function down()
    {
        Schema::drop('themes_setting_key_translations', function (Blueprint $table) {
            $table->dropForeign('translations_to_theme_setting_keys');
        });

        Schema::drop('themes_setting_keys', function (Blueprint $table) {
            $table->dropForeign('theme_setting_keys_to_theme');
            $table->dropForeign('theme_setting_keys_to_key_type');
        });

        Schema::drop('themes_setting_key_types', function (Blueprint $table) {
        });
    }
}
