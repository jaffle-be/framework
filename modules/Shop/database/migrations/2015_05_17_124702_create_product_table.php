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
            $table->string('ean');
            $table->string('upc');
            $table->timestamps();
        });

        Schema::create('product_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'translation_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->string('locale', 5);
            $table->boolean('published');
            $table->string('name');
            $table->string('slug');
            $table->string('title');
            $table->text('content');
            $table->text('cached_content');
            $table->text('cached_extract');
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
        Schema::drop('product_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_product');
        });

        Schema::drop('products', function (Blueprint $table) {
            $table->dropForeign('product_to_brand');
        });
    }
}
