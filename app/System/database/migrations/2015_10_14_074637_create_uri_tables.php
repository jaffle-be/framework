<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUriTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uris', function(Blueprint $table){
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'uri_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('locale_id', false, true);
            $table->foreign('locale_id', 'uri_to_locale')->references('id')->on('locales')->onDelete('cascade');

            $table->string('uri');
            $table->string('owner_type');
            $table->integer('owner_id', false, true);

            $table->timestamps();

            $table->unique(['account_id', 'locale_id', 'uri']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('uris', function(Blueprint $table){
            $table->dropForeign('uri_to_account');
            $table->dropForeign('uri_to_locale');
        });
    }
}