<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaVideos extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true)->nullable();
            $table->foreign('account_id', 'videos_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('owner_type')->nullable();
            $table->integer('owner_id', false, true)->nullable();
            $table->string('provider');
            $table->string('provider_id');
            $table->string('provider_thumbnail');
            $table->smallInteger('width');
            $table->smallInteger('height');
            $table->smallInteger('sort');
            $table->timestamps();

            $table->index(['owner_type', 'owner_id'], 'media_video_owners');
        });

        Schema::create('media_video_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('video_id', false, true);
            $table->foreign('video_id', 'video_translation_to_video')->references('id')->on('media_videos')->onDelete('cascade');
            $table->string('locale');
            $table->string('title');
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
        Schema::drop('media_video_translations', function (Blueprint $table) {
            $table->dropForeign('video_translation_to_video');
        });

        Schema::drop('media_videos', function (Blueprint $table) {
            $table->dropIndex('media_video_owners');
        });
    }
}
