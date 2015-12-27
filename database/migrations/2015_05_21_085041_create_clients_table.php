<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'clients_to_accounts')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('name');
            $table->string('website');
            $table->timestamps();
        });

        Schema::create('account_clients_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id', false, true);
            $table->foreign('client_id', 'translations_to_clients')->references('id')->on('account_clients')->onDelete('cascade');
            $table->string('locale', 5);
            $table->text('description');
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
        Schema::drop('account_clients_translations', function (Blueprint $table) {
            $table->dropForeign('translations_to_clients');
        });

        Schema::drop('account_clients', function (Blueprint $table) {
            $table->dropForeign('clients_to_accounts');
        });
    }
}
