<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            //authentication fields
            $table->string('email');
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone', 50);
            $table->string('vat', 25);
            $table->string('website', 300);
            $table->boolean('confirmed')->default(0);

            //tokens
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users');
    }
}
