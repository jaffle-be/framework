<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactSocialLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_social_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'contact_social_links_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('owner_id', false, true);
            $table->string('owner_type');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('google');
            $table->string('pinterest');
            $table->string('linkedin');
            $table->string('vimeo');
            $table->string('rss');
            $table->string('skype');
            $table->string('dribbble');
            $table->string('youtube');
            $table->string('instagram');
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
        Schema::drop('contact_social_links', function (Blueprint $table) {
            $table->dropForeign('contact_social_links_to_account');
        });
    }
}
