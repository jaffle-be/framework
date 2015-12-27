<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembershipsTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account_memberships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'membership_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'membership_to_user')->references('id')->on('users')->onDelete('cascade');
            $table->integer('role_id', false, true)->nullable();
            $table->foreign('role_id', 'membership_to_role')->references('id')->on('account_membership_roles')->onDelete('cascade');
            $table->boolean('is_owner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('account_memberships', function (Blueprint $table) {
            $table->dropForeign('membership_to_user');
            $table->dropForeign('membership_to_account');
        });
    }
}
