<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandsPivotTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_brands_pivot', function (Blueprint $table) {
            $table->integer('brand_id', false, true);
            $table->foreign('brand_id', 'categories_brand_pivot_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'categories_brand_pivot_to_category')->references('id')->on('product_categories')->onDelete('cascade');
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
        Schema::drop('product_brands_pivot', function (Blueprint $table) {
            $table->dropForeign('categories_brand_pivot_to_brand');
            $table->dropForeign('categories_brand_pivot_to_category');
        });
    }

}
