<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortfolioProjectTranslations extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('portfolio_project_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale', 3);
            $table->integer('project_id', false, true);
            $table->foreign('project_id', 'project_translations_to_project')->references('id')->on('portfolio_projects')->onDelete('cascade');
            $table->boolean('published');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('content');
            $table->text('cached_content');
            $table->text('cached_extract');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('portfolio_project_translations');
    }
}
