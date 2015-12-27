<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaggablesTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->integer('tag_id', false, true);
            $table->foreign('tag_id', 'taggables_to_tag')->references('id')->on('tags')->onDelete('cascade');
            $table->integer('taggable_id', false, true);
            $table->string('taggable_type', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('taggables');
    }
}
