<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioProjectCollaborators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_project_collaborators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id', false, true);
            $table->foreign('project_id', 'project_collaborators_to_projects')->references('id')->on('portfolio_projects');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'project_collaborators_to_users')->references('id')->on('users');
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
        Schema::drop('portfolio_project_collaborators', function(Blueprint $table)
        {
            $table->dropForeign('project_collaborators_to_projects');
            $table->dropForeign('project_collaborators_to_users');
        });
    }
}
