<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBrandTable
 */
class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('product_brand_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id', false, true);
            $table->foreign('brand_id', 'translation_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name', 50);
            $table->string('slug', 50);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('product_brand_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_brand');
        });

        Schema::drop('product_brands');
    }
}
