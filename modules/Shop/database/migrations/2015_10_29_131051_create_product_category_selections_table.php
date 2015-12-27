<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductCategorySelectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_gamma_selected_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'gamma_category_selection_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'gamma_category_selection_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->unique(['account_id', 'category_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('product_gamma_selected_categories', function (Blueprint $table) {
            $table->dropForeign('gamma_category_selection_to_account');
            $table->dropForeign('gamma_category_selection_to_category');
        });
    }
}
