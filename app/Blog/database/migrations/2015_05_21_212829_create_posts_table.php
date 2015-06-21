<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'post_to_user')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('post_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id', false, true);
            $table->foreign('post_id', 'post_translation_to_post')->references('id')->on('posts');
            $table->enum('locale', config('translatable.locales'))->index();
            $table->string('title');
            $table->text('extract');
            $table->text('content');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'post_translation_to_user')->references('id')->on('users');
            $table->date('publish_at')->nullable()->index();
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
        Schema::drop('post_translations', function (Blueprint $table){
            $table->dropForeign('post_translation_to_user');
            $table->dropForeign('post_translation_to_post');
        });


        Schema::drop('posts', function (Blueprint $table) {
            $table->dropForeign('post_to_user');
        });


    }
}
