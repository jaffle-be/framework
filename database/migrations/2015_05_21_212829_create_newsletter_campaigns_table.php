<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsletterCampaignsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'newsletter_campaign_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'newsletter_campaign_to_user')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('use_intro');
            $table->timestamps();
        });

        Schema::create('newsletter_campaign_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id', false, true);
            $table->foreign('campaign_id', 'translation_to_newsletter_campaign')->references('id')->on('newsletter_campaigns')->onDelete('cascade');
            $table->string('locale');
            $table->string('mail_chimp_campaign_id', 100)->nullable();
            $table->string('title');
            $table->string('subject');
            $table->string('intro');

            $table->timestamps();
        });


        Schema::create('newsletter_campaign_widgets', function(Blueprint $table){
            $table->increments('id');

            $table->integer('campaign_id', false, true);
            $table->foreign('campaign_id', 'newsletter_widget_to_campaign')->references('id')->on('newsletter_campaigns')->onDelete('cascade');
            //path to widget view
            $table->string('path');
            $table->boolean('manual');
            $table->integer('image_id', false, true)->nullable();
            $table->foreign('image_id', 'widget_image_to_image')->references('id')->on('media_images')->onDelete('set null');
            $table->integer('image_left_id', false, true)->nullable();
            $table->foreign('image_left_id', 'widget_left_image_to_image')->references('id')->on('media_images')->onDelete('set null');
            $table->integer('image_right_id', false, true)->nullable();
            $table->foreign('image_right_id', 'widget_right_image_to_image')->references('id')->on('media_images')->onDelete('set null');

            $table->string('resource_type')->nullable();
            $table->integer('resource_id', false, true)->nullable();
            $table->string('other_resource_type')->nullable();
            $table->integer('other_resource_id', false, true)->nullable();
            $table->integer('sort');
            $table->timestamps();
        });
        
        Schema::create('newsletter_campaign_widget_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('campaign_widget_id', false, true);
            $table->foreign('campaign_widget_id', 'translation_to_newsletter_widget')->references('id')->on('newsletter_campaign_widgets')->onDelete('cascade');
            $table->string('locale')->nullable();
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->string('title_left')->nullable();
            $table->string('text_left')->nullable();
            $table->string('title_right')->nullable();
            $table->string('text_right')->nullable();
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

        Schema::drop('newsletter_campaign_widget_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_newsletter_widget');
        });

        Schema::drop('newsletter_campaign_widgets', function (Blueprint $table) {
            $table->dropForeign('newsletter_widget_to_campaign');
            $table->dropForeign('widget_image_to_image');
            $table->dropForeign('widget_left_image_to_image');
            $table->dropForeign('widget_right_image_to_image');
        });

        Schema::drop('newsletter_campaign_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_newsletter_campaign');
        });

        Schema::drop('newsletter_campaigns', function (Blueprint $table) {
            $table->dropForeign('newsletter_campaign_to_user');
        });


    }
}
