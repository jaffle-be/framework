<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'price_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'price_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->dateTime('active_from');
            $table->dateTime('active_to');
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('product_prices_active', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'active_price_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'active_price_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->dateTime('activated_on');
            $table->float('value');
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
        Schema::drop('product_prices_active', function (Blueprint $table) {
            $table->dropForeign('active_price_to_account');
            $table->dropForeign('active_price_to_product');
        });
        Schema::drop('product_prices', function (Blueprint $table) {
            $table->dropForeign('price_to_account');
            $table->dropForeign('price_to_product');
        });
    }
}
