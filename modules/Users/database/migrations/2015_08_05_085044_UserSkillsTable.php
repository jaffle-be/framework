<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserSkillsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_skills', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('user_skills_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'skill_selection_to_user')->references('id')->on('users')->onDelete('cascade');
            $table->integer('skill_id', false, true);
            $table->foreign('skill_id', 'skill_selection_to_skill')->references('id')->on('user_skills')->onDelete('cascade');
            $table->integer('level');
            $table->integer('sort');
            $table->timestamps();
        });

        Schema::create('user_skills_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('skill_id', false, true);
            $table->foreign('skill_id', 'translation_to_user_skill')->references('id')->on('user_skills')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name', 75);
            $table->text('description', 1000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('user_skills_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_user_skill');
        });

        Schema::drop('user_skills_selection', function (Blueprint $table) {
            $table->dropForeign('skill_selection_to_user');
            $table->dropForeign('skill_selection_to_skill');
        });

        Schema::drop('user_skills', function (Blueprint $table) {
            $table->dropForeign('skill_to_user');
        });
    }
}
