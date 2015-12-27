<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaFiles extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('media_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true)->nullable();
            $table->foreign('account_id', 'files_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('locale_id', false, true);
            $table->foreign('locale_id', 'media_file_to_locale')->references('id')->on('locales')->onDelete('cascade');
            $table->string('owner_type')->nullable();
            $table->integer('owner_id', false, true)->nullable();
            $table->string('title');
            $table->string('path');
            $table->string('filename');
            $table->string('extension', 15);
            $table->smallInteger('sort');
            $table->timestamps();

            $table->index(['owner_type', 'owner_id'], 'media_file_owners');
            $table->unique(['owner_type', 'owner_id', 'locale_id', 'filename']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('media_files', function (Blueprint $table) {
            $table->dropIndex('media_file_owners');
            $table->dropForeign('media_file_to_locale');
        });
    }
}
