<?php

use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;

$factory->define(Brand::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->userName();

    return [
        'nl'         => [
            'name'        => $name,
            'description' => $faker->text(),
            'created_at'  => $faker->dateTimeBetween('-1 years', '-1 months'),
            'updated_at'  => $faker->dateTimeBetween('-1 months', 'now'),
        ],
        'en'         => [
            'name'        => $name,
            'description' => $faker->text(),
            'created_at'  => $faker->dateTimeBetween('-1 years', '-1 months'),
            'updated_at'  => $faker->dateTimeBetween('-1 months', 'now'),
        ],

        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});

$factory->define(Category::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->userName();
    return [
        'nl'         => [
            'name'       => $name,
            'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
            'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
        ],
        'en'         => [
            'name'       => $name,
            'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
            'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
        ],

        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
    $ean = $faker->ean13;
    $name = $faker->unique()->userName();
    return [
        'ean' => $ean,
        'upc' => substr($ean, 0, 12),
        'nl' => [
            'name' => $name,
            'title' => $faker->sentence(),
            'content' => $faker->realText(500),
            'published' => $faker->boolean(),
        ],
        'en' => [
            'name' => $name,
            'title' => $faker->sentence(),
            'content' => $faker->realText(500),
            'published' => $faker->boolean(),
        ],

        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});