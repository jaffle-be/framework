<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountModulesTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'account_module_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('module_id', false, true);
            $table->foreign('module_id', 'account_module_to_module')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('account_modules', function (Blueprint $table) {
            $table->dropForeign('account_module_to_account');
            $table->dropForeign('account_module_to_module');
        });
    }
}
