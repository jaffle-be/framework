<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id', false, true);
            $table->foreign('brand_id', 'product_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->string('eancode');
            $table->string('upc');
            $table->string('name');
            $table->text('text');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products', function (Blueprint $table) {
            $table->dropForeign('product_to_brand');
        });
    }
}
