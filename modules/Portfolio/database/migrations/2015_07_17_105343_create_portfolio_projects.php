<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Module\Module;
use Modules\Module\ModuleRoute;

class CreatePortfolioProjects extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'project_to_account')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('client_id', false, true)->nullable();
            $table->foreign('client_id', 'project_to_client')->references('id')->on('account_clients')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('website');
            $table->timestamps();
        });

        //install the module itself.
        $module = Module::create([
            'namespace' => 'portfolio',
            'nl'        => [
                'name' => 'Portfolio',
            ],
            'en'        => [
                'name' => 'Portfolio',
            ],
            'fr'        => [
                'name' => 'Portfolio',
            ],
            'de'        => [
                'name' => 'Portfolio',
            ]
        ]);

        $module->routes()->save(new ModuleRoute([
            'name' => 'store.portfolio.index',
            'nl'   => [
                'title' => 'portfolio overview'
            ],
            'en'   => [
                'title' => 'portfolio overview'
            ],
            'fr'   => [
                'title' => 'portfolio overview'
            ],
            'de'   => [
                'title' => 'portfolio overview'
            ],

        ]));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('portfolio_projects', function (Blueprint $table) {
            $table->dropForeign('project_to_account');
            $table->dropForeign('project_to_client');
        });

        Module::where('namespace', 'portfolio')->delete();
    }
}
