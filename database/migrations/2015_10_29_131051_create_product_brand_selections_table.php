<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductBrandSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_gamma_selected_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'gamma_brand_selection_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('brand_id', false, true);
            $table->foreign('brand_id', 'gamma_brand_selection_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->unique(['account_id', 'brand_id']);
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
        Schema::drop('product_gamma_selected_brands', function (Blueprint $table) {
            $table->dropForeign('gamma_brand_selection_to_account');
            $table->dropForeign('gamma_brand_selection_to_brand');
        });
    }
}
