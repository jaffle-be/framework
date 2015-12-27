<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductGammaTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_gamma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'gamma_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'gamma_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->integer('brand_id', false, true);
            $table->foreign('brand_id', 'gamma_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->unique(['account_id', 'product_id', 'brand_id']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_gamma_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('selection_id', false, true);
            $table->foreign('selection_id', 'category_selection_to_product_selection')->references('id')->on('product_gamma')->onDelete('cascade');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'gamma_category_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->unique(['selection_id', 'category_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('product_gamma_categories', function (Blueprint $table) {
            $table->dropForeign('gamma_category_to_category');
            $table->dropForeign('category_selection_to_product_selection');
        });

        Schema::drop('product_gamma', function (Blueprint $table) {
            $table->dropForeign('gamma_to_account');
            $table->dropForeign('gamma_to_product');
            $table->dropForeign('gamma_to_brand');
        });
    }
}
