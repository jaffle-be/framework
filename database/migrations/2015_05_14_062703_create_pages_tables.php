<?php

use App\Module\Module;
use App\Module\ModuleRoute;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'page_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('parent_id', false, true)->nullable();
            $table->foreign('parent_id', 'page_to_parent_page')->references('id')->on('pages')->onDelete('cascade');
            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'page_to_user')->references('id')->on('users')->onDelete('cascade');
            $table->smallInteger('sort');
            $table->timestamps();
        });

        Schema::create('page_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('page_id', false, true);
            $table->foreign('page_id', 'page_translation_to_page')->references('id')->on('pages')->onDelete('cascade');
            $table->string('locale');
            $table->string('title');
            $table->text('content');
            $table->boolean('published');
            $table->timestamps();
        });

        //install the module itself.
        $module = Module::create([
            'namespace' => 'pages',
            'nl'     => [
                'name' => 'Pages',
            ],
            'en'     => [
                'name' => 'Pages',
            ],
            'fr'     => [
                'name' => 'Pages',
            ],
            'de'     => [
                'name' => 'Pages',
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('page_translations', function(Blueprint $table){
            $table->dropForeign('page_translation_to_page');
        });

        Schema::drop('pages', function(Blueprint $table){
            $table->dropForeign('page_to_account');
            $table->dropForeign('page_to_parent_page');
        });

        Module::where('namespace', 'pages')->delete();
    }
}
