<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountRolesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account_membership_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true)->nullable();
            $table->foreign('account_id', 'account_membership_roles_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('account_membership_roles_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale', 5);
            $table->string('name');
            $table->integer('role_id', false, true);
            $table->foreign('role_id', 'translation_to_account_membership_roles')->references('id')->on('account_membership_roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('account_membership_roles_translations', function (Blueprint $table) {
            $table->dropForeign('account_membership_roles_id');
        });

        Schema::drop('account_membership_roles', function (Blueprint $table) {
            $table->dropForeign('account_membership_roles_to_account');
        });
    }
}
