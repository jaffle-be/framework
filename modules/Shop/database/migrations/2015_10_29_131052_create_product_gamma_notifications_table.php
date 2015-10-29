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
            $table->string('owner_type');
            $table->integer('owner_id', false, true);
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
        });
    }

}
