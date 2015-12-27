<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateMembershipInvitationsTable
 */
class CreateMembershipInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account_membership_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'membership_invitation_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('email');
            $table->string('token', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('account_membership_invitations', function (Blueprint $table) {
            $table->dropForeign('membership_invitation_to_account');
        });
    }
}
