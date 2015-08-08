<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountContactInformationTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_contact_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'account_contact_information_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('email');
            $table->string('phone');
            $table->string('vat');
            $table->string('website');
            $table->string('hours');
            $table->timestamps();
        });

        Schema::create('account_contact_information_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale', 5);
            $table->text('form_description');
            $table->string('widget_title');
            $table->text('widget_content');
            $table->integer('account_contact_information_id', false, true);
            $table->foreign('account_contact_information_id', 'translation_to_account_contact_information')->references('id')->on('account_contact_information')->onDelete('cascade');
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
        Schema::drop('account_contact_information_translations', function (Blueprint $table) {
            $table->dropForeign('account_contact_information_id');
        });

        Schema::drop('account_contact_information', function (Blueprint $table) {
            $table->dropForeign('account_contact_information_to_account');
        });
    }

}
