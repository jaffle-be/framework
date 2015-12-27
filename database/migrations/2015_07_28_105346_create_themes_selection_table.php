<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemesSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes_selections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('theme_id', false, true);
            $table->foreign('theme_id', 'theme_selection_to_themes')->references('id')->on('themes')->onDelete('cascade');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'theme_selection_to_accounts')->references('id')->on('accounts')->onDelete('cascade');
            $table->boolean('active');
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
        Schema::drop('themes_selections', function (Blueprint $table) {
            $table->dropForeign('theme_selection_to_themes');
            $table->dropForeign('theme_selection_to_accounts');
        });
    }
}
