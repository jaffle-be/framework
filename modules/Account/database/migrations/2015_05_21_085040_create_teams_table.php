<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Module\Module;
use Modules\Module\ModuleRoute;

class CreateTeamsTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('account_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'teams_to_accounts')->references('id')->on('accounts')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('account_teams_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id', false, true);
            $table->foreign('team_id', 'translations_to_teams')->references('id')->on('account_teams')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('account_team_memberships', function (Blueprint $table) {
            $table->integer('team_id', false, true);
            $table->foreign('team_id', 'team_membership_to_team')->references('id')->on('account_teams')->onDelete('cascade');
            $table->integer('membership_id', false, true);
            $table->foreign('membership_id', 'team_membership_to_membership')->references('id')->on('account_memberships')->onDelete('cascade');
            $table->timestamps();
        });

        //install the module itself.
        $module = Module::create([
            'namespace' => 'team',
            'nl' => [
                'name' => 'Team',
            ],
            'en' => [
                'name' => 'Team',
            ],
            'fr' => [
                'name' => 'Team',
            ],
            'de' => [
                'name' => 'Team',
            ],
        ]);

        $module->routes()->save(new ModuleRoute([
            'name' => 'store.team.index',
            'nl' => [
                'title' => 'team',
            ],
            'en' => [
                'title' => 'team',
            ],
            'fr' => [
                'title' => 'team',
            ],
            'de' => [
                'title' => 'team',
            ],

        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('account_team_memberships', function (Blueprint $table) {
            $table->dropForeign('team_membership_to_team');
            $table->dropForeign('team_membership_to_membership');
        });

        Schema::drop('account_teams_translations', function (Blueprint $table) {
            $table->dropForeign('translations_to_teams');
        });

        Schema::drop('account_teams', function (Blueprint $table) {
            $table->dropForeign('teams_to_accounts');
        });

        Module::where('namespace', 'team')->delete();
    }
}
