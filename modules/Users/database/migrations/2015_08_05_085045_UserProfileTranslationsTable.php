<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserProfileTranslationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'profile_translation_to_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('locale', 5);
            $table->text('bio');
            $table->string('quote');
            $table->string('quote_author');
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
        Schema::drop('user_profile_translations', function (Blueprint $table) {
            $table->dropForeign('profile_translation_to_user');
        });
    }

}
