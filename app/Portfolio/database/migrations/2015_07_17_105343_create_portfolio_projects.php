<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortfolioProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'project_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('client_id', false, true)->nullable();
            $table->foreign('client_id', 'project_to_client')->references('id')->on('account_clients')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('website');
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
        Schema::drop('portfolio_projects', function(Blueprint $table){
            $table->dropForeign('project_to_account');
            $table->dropForeign('project_to_client');
        });
    }
}
