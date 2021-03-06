<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateCategoriesPivotTable
 */
class CreateCategoriesPivotTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_categories_pivot', function (Blueprint $table) {
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'categories_product_pivot_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'categories_product_pivot_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('product_categories_pivot', function (Blueprint $table) {
            $table->dropForeign('categories_product_pivot_to_product');
            $table->dropForeign('categories_product_pivot_to_category');
        });
    }
}
