<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_memberships', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'membership_to_account')->references('id')->on('accounts');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'membership_to_user')->references('id')->on('users');
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
        Schema::drop('account_memberships', function (Blueprint $table) {
            $table->dropForeign('membership_to_user');
            $table->dropForeign('membership_to_account');
        });
    }
}
