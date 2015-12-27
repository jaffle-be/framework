<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Module\Module;

class InstallMarketingModule extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //install the module itself.
        $module = Module::create([
            'namespace' => 'marketing',
            'nl' => [
                'name' => 'Marketing',
            ],
            'en' => [
                'name' => 'Marketing',
            ],
            'fr' => [
                'name' => 'Marketing',
            ],
            'de' => [
                'name' => 'Marketing',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Module::where('namespace', 'marketing')->delete();
    }
}
