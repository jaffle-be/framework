<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'post_to_account')->references('id')->on('accounts')->onDelete('cascade');

            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'post_to_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('slug_nl', 200);
            $table->string('slug_fr', 200);
            $table->string('slug_en', 200);
            $table->string('slug_de', 200);
            $table->timestamps();
        });

        Schema::create('post_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id', false, true);
            $table->foreign('post_id', 'post_translation_to_post')->references('id')->on('posts')->onDelete('cascade');
            $table->string('locale');
            $table->string('title');
            $table->text('extract');
            $table->text('content');
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
            $table->dropForeign('post_translation_to_post');
        });


        Schema::drop('posts', function (Blueprint $table) {
            $table->dropForeign('post_to_user');
        });


    }
}
