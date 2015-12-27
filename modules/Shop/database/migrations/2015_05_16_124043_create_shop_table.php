<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Module\Module;
use Modules\Module\ModuleRoute;

/**
 * Class CreateShopTable
 */
class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $module = Module::create([
            'namespace' => 'shop',
            'nl' => ['name' => 'Shop'],
            'en' => ['name' => 'Shop'],
            'fr' => ['name' => 'Shop'],
            'de' => ['name' => 'Shop'],
        ]);

        $module->routes()->save(new ModuleRoute([
            'name' => 'store.shop.index',
            'nl' => ['title' => 'shopping home page'],
            'fr' => ['title' => 'shopping home page'],
            'en' => ['title' => 'shopping home page'],
            'de' => ['title' => 'shopping home page'],
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Module::where('namespace', 'shop')->delete();
    }
}
