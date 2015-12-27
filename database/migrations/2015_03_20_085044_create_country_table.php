<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iso_code_2', 2);
            $table->string('iso_code_3', 3);
        });

        Schema::create('country_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id', false, true);
            $table->foreign('country_id', 'translation_to_country')->references('id')->on('country')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('country_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_country');
        });

        Schema::drop('country', function (Blueprint $table) {
        });
    }
}
