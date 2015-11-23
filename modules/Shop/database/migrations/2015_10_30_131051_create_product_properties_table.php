<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductPropertiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_properties_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'property_group_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->integer('sort');
            $table->timestamps();
        });

        Schema::create('product_properties_groups_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id', false, true);
            $table->foreign('group_id', 'translation_to_product_property_group')->references('id')->on('product_properties_groups')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('product_properties_units', function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('product_properties_units_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('unit_id', false, true);
            $table->foreign('unit_id', 'translation_to_product_property_unit')->references('id')->on('product_properties_units')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->string('unit');
            $table->timestamps();
        });

        Schema::create('product_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id', false, true);
            $table->foreign('category_id', 'product_property_to_category')->references('id')->on('product_categories')->onDelete('cascade');
            $table->integer('group_id', false, true);
            $table->foreign('group_id', 'product_property_to_group')->references('id')->on('product_properties_groups')->onDelete('cascade');

            $table->integer('unit_id', false, true)->nullable();
            $table->foreign('unit_id', 'product_to_product_property_unit')->references('id')->on('product_properties_units')->onDelete('cascade');
            //boolean, string, numeric, float, option
            $table->string('type');
            $table->integer('sort');
            $table->timestamps();
        });

        Schema::create('product_properties_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id', false, true);
            $table->foreign('property_id', 'translation_to_product_property')->references('id')->on('product_properties')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('product_properties_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id', false, true);
            $table->foreign('property_id', 'property_option_to_product_property')->references('id')->on('product_properties')->onDelete('cascade');
            $table->integer('sort');
            $table->timestamps();
        });

        Schema::create('product_properties_options_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_id', false, true);
            $table->foreign('option_id', 'translation_to_product_property_option')->references('id')->on('product_properties_options_translations')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('product_properties_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id', false, true);
            $table->foreign('product_id', 'property_value_to_product')->references('id')->on('products')->onDelete('cascade');
            $table->integer('property_id', false, true);
            $table->foreign('property_id', 'property_value_to_product_property')->references('id')->on('product_properties')->onDelete('cascade');
            $table->integer('option_id', false, true)->nullable();
            $table->foreign('option_id', 'property_value_to_product_property_option')->references('id')->on('product_properties_options')->onDelete('cascade');
            $table->integer('boolean')->nullable();
            $table->integer('numeric')->nullable();
            $table->float('float')->nullable();
            $table->timestamps();
        });

        Schema::create('product_properties_values_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('value_id', false, true);
            $table->foreign('value_id', 'translation_to_product_property_value')->references('id')->on('product_properties_values')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('string')->nullable();
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
        Schema::drop('product_properties_values_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_product_property_value');
        });

        Schema::drop('product_properties_values', function (Blueprint $table) {
            $table->dropForeign('property_value_to_product');
            $table->dropForeign('property_value_to_product_property');
            $table->dropForeign('property_value_to_product_property_option');
        });

        Schema::drop('product_properties_options_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_product_property_option');
        });

        Schema::drop('product_properties_options', function (Blueprint $table) {
            $table->dropForeign('property_option_to_product_property');
        });

        Schema::drop('product_properties_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_product_property');
        });

        Schema::drop('product_properties', function (Blueprint $table) {
            $table->dropForeign('product_property_to_category');
            $table->dropForeign('product_property_to_group');
            $table->dropForeign('product_to_product_property_unit');
        });

        Schema::drop('product_properties_units_translations', function (Blueprint $table) {
            $table->dropForeign('translation_to_product_property_unit');
        });

        Schema::drop('product_properties_units', function (Blueprint $table) {
        });

        Schema::drop('product_properties_groups_translations', function(Blueprint $table){
            $table->dropForeign('translation_to_product_property_group');
        });

        Schema::drop('product_properties_groups', function(Blueprint $table){
            $table->dropForeign('property_group_to_category');
        });
    }

}
