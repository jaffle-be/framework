<?php

use App\Shop\Product\Price;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'prices_to_product')->references('id')->on('products');
            $table->float('value');
            $table->timestamps();
        });

        Price::create([
            'product_id' => 1,
            'value'      => 50
        ]);

        Price::create([
            'product_id' => 2,
            'value'      => 35
        ]);

        Price::create([
            'product_id' => 3,
            'value'      => 60
        ]);

        Price::create([
            'product_id' => 4,
            'value'      => 159
        ]);

        Price::create([
            'product_id' => 5,
            'value'      => 60
        ]);

        Price::create([
            'product_id' => 6,
            'value'      => 70
        ]);

        Price::create([
            'product_id' => 7,
            'value'      => 99
        ]);

        Price::create([
            'product_id' => 8,
            'value'      => 123
        ]);

        Price::create([
            'product_id' => 9,
            'value'      => 12.99
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_prices', function (Blueprint $table) {
            $table->dropForeign('prices_to_product');
        });
    }
}
