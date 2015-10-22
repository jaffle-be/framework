<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
			$table->foreign('product_id', 'promotions_to_product')->references('id')->on('products')->onDelete('cascade');
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
		Schema::drop('product_promotions', function(Blueprint $table){
			$table->dropForeign('promotions_to_product');
		});
	}

}
