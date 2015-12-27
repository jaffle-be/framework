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
            $table->integer('locale_id', false, true);
            $table->foreign('locale_id', 'media_video_to_locale')->references('id')->on('locales')->onDelete('cascade');
            $table->string('owner_type')->nullable();
            $table->integer('owner_id', false, true)->nullable();
            $table->string('provider');
            $table->string('provider_id');
            $table->string('provider_thumbnail');
            $table->string('title');
            $table->string('description');
            $table->smallInteger('width');
            $table->smallInteger('height');
            $table->smallInteger('sort');
            $table->timestamps();

            $table->index(['owner_type', 'owner_id'], 'media_video_owners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('media_videos', function (Blueprint $table) {
            $table->dropIndex('media_video_owners');
            $table->dropForeign('media_video_to_locale');
        });
    }
}
