<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortfolioProjectTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_project_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale', 3);
            $table->integer('project_id', false, true);
            $table->foreign('project_id', 'project_translations_to_project')->references('id')->on('portfolio_projects')->onDelete('cascade');
            $table->string('title');
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
        Schema::drop('portfolio_project_translations');
    }
}
