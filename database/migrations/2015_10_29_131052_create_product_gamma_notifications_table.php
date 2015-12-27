<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductGammaNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_gamma_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'gamma_notification_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('brand_id', false, true)->nullable();
            $table->foreign('brand_id', 'gamma_notification_to_brand')->references('id')->on('product_brands')->onDelete('cascade');
            $table->integer('category_id', false, true)->nullable();
            $table->foreign('category_id', 'gamma_notification_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->integer('product_id', false, true)->nullable();
            $table->foreign('product_id', 'gamma_notification_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->boolean('processing');
            $table->string('type', 15);
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
        Schema::drop('product_gamma_notifications', function (Blueprint $table) {
            $table->dropForeign('gamma_notification_to_account');
            $table->dropForeign('gamma_notification_to_brand');
            $table->dropForeign('gamma_notification_to_category');
            $table->dropForeign('gamma_notification_to_product');
        });
    }
}
