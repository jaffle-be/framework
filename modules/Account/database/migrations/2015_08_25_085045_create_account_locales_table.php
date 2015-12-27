<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountLocalesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account_locales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'account_locale_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('locale_id', false, true);
            $table->foreign('locale_id', 'account_locale_to_locale')->references('id')->on('locales')->onDelete('cascade');
            $table->boolean('default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('account_locales', function (Blueprint $table) {
            $table->dropForeign('account_locale_to_account');
            $table->dropForeign('account_locale_to_locale');
        });
    }
}
