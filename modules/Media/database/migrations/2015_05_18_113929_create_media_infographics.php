<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaInfographics extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('media_infographics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true)->nullable();
            $table->foreign('account_id', 'infographics_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('locale_id', false, true);
            $table->foreign('locale_id', 'infographic_to_locale')->references('id')->on('locales')->onDelete('cascade');
            $table->string('owner_type')->nullable();
            $table->integer('owner_id', false, true)->nullable();
            $table->integer('original_id', false, true)->nullable();
            $table->foreign('original_id', 'thumbnail_to_original_infographics')->references('id')->on('media_infographics')->onDelete('cascade');
            $table->string('title');
            $table->string('path');
            $table->string('filename');
            $table->string('extension', 15);
            $table->integer('width');
            $table->integer('height');
            $table->smallInteger('sort');
            $table->timestamps();

            $table->index(['owner_type', 'owner_id'], 'media_infographic_owners');
            $table->unique(['owner_type', 'owner_id', 'locale_id', 'filename']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('media_infographics', function (Blueprint $table) {
            $table->dropIndex('media_infographic_owners');
            $table->dropForeign('thumbnail_to_original_infographics');
            $table->dropForeign('infographic_to_locale');
        });
    }
}
