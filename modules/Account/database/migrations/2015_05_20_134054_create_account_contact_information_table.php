<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateAccountContactInformationTable
 */
class CreateAccountContactInformationTable extends Migration
{
    /**
     * Run the migrations.
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
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('account_contact_information', function (Blueprint $table) {
            $table->dropForeign('account_contact_information_to_account');
        });
    }
}
