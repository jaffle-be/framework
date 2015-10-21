<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namespace');
            $table->timestamps();
        });

        Schema::create('module_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id', false, true);
            $table->foreign('module_id', 'translation_to_module')->references('id')->on('modules')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('module_routes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('module_id', false, true);
            $table->foreign('module_id', 'route_to_module')->references('id')->on('modules')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('module_route_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_route_id', false, true);
            $table->foreign('module_route_id', 'translation_to_module_route')->references('id')->on('module_routes')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('title');
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
        Schema::drop('module_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_module');
        });

        Schema::drop('module_route_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_module_route');
        });

        Schema::drop('module_routes', function(Blueprint $table)
        {
            $table->dropForeign('route_to_module');
        });

        Schema::drop('modules', function (Blueprint $table) {
            //
        });

    }

}
