<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateThemesSelectionTable
 */
class CreateThemesSelectionTable extends Migration
{
    /**
     * Run the migrations.
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
     */
    public function down()
    {
        Schema::drop('themes_selections', function (Blueprint $table) {
            $table->dropForeign('theme_selection_to_themes');
            $table->dropForeign('theme_selection_to_accounts');
        });
    }
}
