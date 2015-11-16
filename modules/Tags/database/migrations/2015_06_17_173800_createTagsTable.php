<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'tag_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tag_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale', 2);
            $table->integer('tag_id', false, true);
            $table->foreign('tag_id', 'translations_to_tags')->references('id')->on('tags')->onDelete('cascade');

            $table->string('name');
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
        Schema::drop('tag_translations', function (Blueprint $table) {
            $table->dropForeign('translations_to_tags');
        });

        Schema::drop('tags');
    }
}
