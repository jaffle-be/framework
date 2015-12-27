<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('original_id', false, true)->nullable();
            $table->foreign('original_id', 'synonym_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'translation_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('product_category_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_category');
        });

        Schema::drop('product_categories', function (Blueprint $table) {
            $table->dropForeign('synonym_to_category');
        });
    }
}
