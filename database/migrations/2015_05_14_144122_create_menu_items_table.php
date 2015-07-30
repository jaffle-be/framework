<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id', false, true);
            $table->foreign('menu_id', 'items_to_menu')->references('id')->on('menus');
            $table->integer('parent_id', false, true)->nullable();
            $table->foreign('parent_id', 'menu_item_to_parent')->references('id')->on('menu_items');
            $table->smallInteger('sort');
            $table->string('url');
            $table->boolean('target_blank');
            $table->timestamps();
        });

        Schema::create('menu_item_translations', function (Blueprint $table) {

            $table->increments('id');
            $table->string('locale', 5);
            $table->integer('menu_item_id', false, true);
            $table->foreign('menu_item_id', 'translations_to_menu_items')->references('id')->on('menu_items');
            $table->string('name', 75);
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
        Schema::drop('menu_item_translations', function(Blueprint $table)
        {
            $table->dropForeign('translations_to_menu_items');
        });

        Schema::drop('menu_items', function (Blueprint $table) {
            $table->dropForeign('menu_item_to_parent');
        });
    }

}
