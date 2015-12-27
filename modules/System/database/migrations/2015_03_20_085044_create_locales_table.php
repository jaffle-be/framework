<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\Locale;

class CreateLocalesTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 5);
        });

        Schema::create('locales_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('locale_id', false, true);
            $table->foreign('locale_id', 'translation_to_locale')->references('id')->on('locales')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
        });

        Locale::create([
            'slug' => 'nl',
            'nl' => ['name' => 'nederlands'],
            'fr' => ['name' => 'néerlandais'],
            'de' => ['name' => 'holländisch'],
            'en' => ['name' => 'dutch'],
        ]);

        Locale::create([
            'slug' => 'fr',
            'nl' => ['name' => 'frans'],
            'fr' => ['name' => 'français'],
            'de' => ['name' => 'französisch'],
            'en' => ['name' => 'french'],
        ]);

        Locale::create([
            'slug' => 'en',
            'nl' => ['name' => 'engels'],
            'fr' => ['name' => 'anglais'],
            'de' => ['name' => 'englisch'],
            'en' => ['name' => 'english'],
        ]);

        Locale::create([
            'slug' => 'de',
            'nl' => ['name' => 'duits'],
            'fr' => ['name' => 'allemand'],
            'de' => ['name' => 'deutsch'],
            'en' => ['name' => 'german'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('locales_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_locale');
        });

        Schema::drop('locales', function (Blueprint $table) {
        });
    }
}
