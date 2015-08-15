<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesPivotTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories_pivot', function (Blueprint $table) {
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'categories_pivot_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'categories_pivot_to_category')->references('id')->on('product_categories')->onDelete('cascade');
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
        Schema::drop('product_categories_pivot', function (Blueprint $table) {
            $table->dropForeign('categories_pivot_to_product');
            $table->dropForeign('categories_pivot_to_category');
        });
    }

}
