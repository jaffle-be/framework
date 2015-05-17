<?php

use App\Menu\MenuItem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('menu_id', false, true);
			$table->foreign('menu_id', 'items_to_menu')->references('id')->on('menus');
			$table->integer('parent_id', false, true)->nullable();
			$table->foreign('parent_id', 'menu_item_to_parent')->references('id')->on('menu_items');

			$table->string('url');
			$table->string('name');
			$table->timestamps();
		});

		MenuItem::create([
			'menu_id' => 1,
			'url' => 'producten',
			'name' => 'producten',
		]);

		MenuItem::create([
			'menu_id' => 1,
			'url' => 'promoties',
			'name' => 'promoties',
		]);

		MenuItem::create([
			'menu_id' => 1,
			'url' => 'nieuwsberichten',
			'name' => 'nieuwsberichten',
		]);

		MenuItem::create([
			'menu_id' => 1,
			'url' => 'contact',
			'name' => 'contact',
		]);

		MenuItem::create([
			'menu_id' => 1,
			'parent_id' => 1,
			'url' => 'tv-vision',
			'name' => 'TV / vision'
		]);

		MenuItem::create([
			'menu_id' => 1,
			'parent_id' => 1,
			'url' => 'telefonie-mobile',
			'name' => 'telefonie / mobile'
		]);

		MenuItem::create([
			'menu_id' => 1,
			'parent_id' => 1,
			'url' => 'computer-tablets',
			'name' => 'computer / tablets'
		]);

		MenuItem::create([
			'menu_id' => 1,
			'parent_id' => 1,
			'url' => 'office-gps',
			'name' => 'office / gps'
		]);

		MenuItem::create([
			'menu_id' => 1,
			'parent_id' => 1,
			'url' => 'huishoud',
			'name' => 'huishoud'
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu_items', function(Blueprint $table)
		{
			$table->dropForeign('menu_item_to_parent');
		});
	}

}
