<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Module\Module;
use Modules\Module\ModuleRoute;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id', false, true);
            $table->foreign('account_id', 'post_to_account')->references('id')->on('accounts')->onDelete('cascade');

            $table->integer('user_id', false, true);
            $table->foreign('user_id', 'post_to_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id', false, true);
            $table->foreign('post_id', 'post_translation_to_post')->references('id')->on('posts')->onDelete('cascade');
            $table->string('locale');
            $table->string('title');
            $table->text('content');
            $table->date('publish_at')->nullable()->index();
            $table->timestamps();
        });

        //install the module itself.
        $module = Module::create([
            'namespace' => 'blog',
            'nl'     => [
                'name' => 'Blog',
            ],
            'en'     => [
                'name' => 'Blog',
            ],
            'fr'     => [
                'name' => 'Blog',
            ],
            'de'     => [
                'name' => 'Blog',
            ]
        ]);

        $module->routes()->save(new ModuleRoute([
            'name' => 'store.blog.index',
            'nl' => [
                'title' => 'blog overview'
            ],
            'en' => [
                'title' => 'blog overview'
            ],
            'fr' => [
                'title' => 'blog overview'
            ],
            'de' => [
                'title' => 'blog overview'
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
        Schema::drop('post_translations', function (Blueprint $table) {
            $table->dropForeign('post_translation_to_post');
        });

        Schema::drop('posts', function (Blueprint $table) {
            $table->dropForeign('post_to_user');
        });

        Module::where('namespace', 'blog')->delete();
    }
}
