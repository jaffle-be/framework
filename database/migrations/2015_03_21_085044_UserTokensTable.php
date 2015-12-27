<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_tokens', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('type');
            $table->string('value', 100);
            $table->dateTime('expires_at');

            $table->index('expires_at', 'user_tokens_expires_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('reset_token_id', false, true)->after('remember_token')->nullable();
            $table->foreign('reset_token_id', 'user_to_reset_token')->references('id')->on('users_tokens')->onDelete('cascade');

            $table->integer('confirmation_token_id', false, true)->after('reset_token_id')->nullable();
            $table->foreign('confirmation_token_id', 'user_to_confirmation_token')->references('id')->on('users_tokens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('user_to_reset_token');
            $table->dropColumn('reset_token_id');

            $table->dropForeign('user_to_confirmation_token');
            $table->dropColumn('confirmation_token_id');
        });

        Schema::drop('users_tokens', function (Blueprint $table) {
            $table->dropIndex('user_tokens_expires_at');
        });
    }
}
