<?php
namespace App\System;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder as BaseSeeder;

abstract class Seeder extends BaseSeeder
{
    /**
     * The Faker instance.
     *
     * @type Faker
     */
    protected $faker;

    protected $nl;

    protected $fr;

    protected $en;

    protected $de;

    /**
     * Build a new Seed.
     */
    public function __construct()
    {
        // Bind Faker instance if available
        if (class_exists('Faker\Factory')) {
            $this->nl = Faker::create('nl_BE');
            $this->fr = Faker::create('fr_BE');
            $this->en = Faker::create('en_US');
            $this->de = Faker::create('de_DE');
            $this->faker = $this->en;
        }
    }

}