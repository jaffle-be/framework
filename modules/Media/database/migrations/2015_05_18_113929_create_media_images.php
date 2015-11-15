<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaImages extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true)->nullable();
            $table->foreign('account_id', 'images_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('owner_type')->nullable();
            $table->integer('owner_id', false, true)->nullable();
            $table->integer('original_id', false, true)->nullable();
            $table->foreign('original_id', 'thumbnail_to_original_images')->references('id')->on('media_images')->onDelete('cascade');
            $table->string('path');
            $table->string('filename');
            $table->string('extension', 15);
            $table->integer('width');
            $table->integer('height');
            $table->smallInteger('sort');
            $table->timestamps();

            $table->index(['owner_type', 'owner_id'], 'media_image_owners');
            $table->unique(['owner_type', 'owner_id', 'filename']);
        });

        Schema::create('media_image_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_id', false, true);
            $table->foreign('image_id', 'image_translation_to_image')->references('id')->on('media_images')->onDelete('cascade');
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
        Schema::drop('media_image_translations', function (Blueprint $table) {
            $table->dropForeign('image_translation_to_image');
        });

        Schema::drop('media_images', function (Blueprint $table) {
            $table->dropIndex('media_image_owners');
            $table->dropForeign('thumbnail_to_original_images');
        });
    }
}
