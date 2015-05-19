<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('owner_type')->nullable();
            $table->integer('owner_id', false, true)->nullable();
            $table->integer('original_id', false, true)->nullable();
            $table->foreign('original_id', 'thumbnail_to_original_images')->references('id')->on('media_images');
            $table->string('path');
            $table->string('filename');
            $table->string('extension');
            $table->integer('width');
            $table->integer('height');
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
        Schema::drop('media_images', function (Blueprint $table) {
            $table->dropForeign('thumbnail_to_original_images');
        });
    }
}
