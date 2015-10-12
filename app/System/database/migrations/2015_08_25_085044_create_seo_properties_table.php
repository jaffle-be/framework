<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\System\Locale;

class CreateSeoPropertiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner_type');
            $table->integer('owner_id', false, true);
            $table->integer('locale_id', false, true);
            $table->foreign('locale_id', 'seo_property_to_locale')->references('id')->on('locales')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
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
        Schema::drop('seo_properties', function (Blueprint $table){
            $table->dropForeign('seo_property_to_locale');
        });
    }
}
