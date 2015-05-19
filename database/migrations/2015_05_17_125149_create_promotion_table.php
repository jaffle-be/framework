<?php

use App\Shop\Product\Promotion;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_promotions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id', false, true);
			$table->foreign('product_id', 'promotions_to_product')->references('id')->on('products');
			$table->float('value');
			$table->timestamps();
		});

		Promotion::create([
			'product_id' => 1,
			'value'      => 39.99
		]);

		Promotion::create([
			'product_id' => 2,
			'value'      => 29.99
		]);

		Promotion::create([
			'product_id' => 3,
			'value'      => 45.99
		]);

		Promotion::create([
			'product_id' => 4,
			'value'      => 149
		]);

		Promotion::create([
			'product_id' => 5,
			'value'      => 50
		]);

		Promotion::create([
			'product_id' => 6,
			'value'      => 60
		]);

		Promotion::create([
			'product_id' => 7,
			'value'      => 89
		]);

		Promotion::create([
			'product_id' => 8,
			'value'      => 115
		]);

		Promotion::create([
			'product_id' => 9,
			'value'      => 9.99
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_promotions', function(Blueprint $table){
			$table->dropForeign('promotions_to_product');
		});
	}

}
