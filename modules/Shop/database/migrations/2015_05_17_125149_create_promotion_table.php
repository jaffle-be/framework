<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromotionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'promotion_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('brand_id', false, true)->nullable();
            $table->foreign('brand_id', 'promotion_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->integer('category_id', false, true)->nullable();
            $table->foreign('category_id', 'promotion_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->integer('product_id', false, true)->nullable();
            $table->foreign('product_id', 'promotion_to_product')->references('id')->on('products')->onDelete('cascade');
            //no means relative ex: 10%
            $table->boolean('absolute');
            $table->dateTime('active_from');
            $table->dateTime('active_to');
            $table->float('value');
            $table->dateTime('from')->nullable();
            $table->dateTime('to')->nullable();
            $table->timestamps();
        });

        Schema::create('product_promotions_active', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'active_promotion_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('brand_id', false, true)->nullable();
            $table->foreign('brand_id', 'active_promotion_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->integer('category_id', false, true)->nullable();
            $table->foreign('category_id', 'active_promotion_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->integer('product_id', false, true)->nullable();
            $table->foreign('product_id', 'active_promotion_to_product')->references('id')->on('products')->onDelete('cascade');
            //no means relative ex: 10%
            $table->boolean('absolute');
            $table->dateTime('activated_on');
            $table->float('value');
            $table->dateTime('from')->nullable();
            $table->dateTime('to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('product_promotions_active', function (Blueprint $table) {
            $table->dropForeign('active_promotion_to_account');
            $table->dropForeign('active_promotion_to_brand');
            $table->dropForeign('active_promotion_to_category');
            $table->dropForeign('active_promotion_to_product');
        });

        Schema::drop('product_promotions', function (Blueprint $table) {
            $table->dropForeign('promotion_to_account');
            $table->dropForeign('promotion_to_brand');
            $table->dropForeign('promotion_to_category');
            $table->dropForeign('promotion_to_product');
        });
    }
}
