<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Module\Module;
use Modules\Module\ModuleRoute;

class CreateContactInformationTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contact_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id', false, true);
            $table->string('owner_type');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('street');
            $table->string('box', 30);
            $table->string('postcode');
            $table->string('city');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('country_id', false, true);
            $table->foreign('country_id', 'contact_address_to_country')->references('id')->on('country');
            $table->timestamps();
        });

        //install the module itself.
        $module = Module::create([
            'namespace' => 'contact',
            'nl' => [
                'name' => 'Contact',
            ],
            'en' => [
                'name' => 'Contact',
            ],
            'fr' => [
                'name' => 'Contact',
            ],
            'de' => [
                'name' => 'Contact',
            ],
        ]);

        $module->routes()->save(new ModuleRoute([
            'name' => 'store.contact.index',
            'nl' => [
                'title' => 'contact',
            ],
            'en' => [
                'title' => 'contact',
            ],
            'fr' => [
                'title' => 'contact',
            ],
            'de' => [
                'title' => 'contact',
            ],

        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('contact_address', function (Blueprint $table) {
            $table->dropForeign('contact_address_to_country');
        });
    }
}
