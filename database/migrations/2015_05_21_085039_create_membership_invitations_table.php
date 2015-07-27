<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_membership_invitations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'membership_invitation_to_account')->references('id')->on('accounts');
            $table->string('email');
            $table->string('token', 200);
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
        Schema::drop('account_membership_invitations', function (Blueprint $table) {
            $table->dropForeign('membership_invitation_to_account');
        });
    }
}
