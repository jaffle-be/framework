<?php

use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductCategorySelection;
use Modules\Shop\Gamma\ProductSelection;

$factory->define(GammaSelection::class, function (Faker\Generator $faker) {

    return [
        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});

$factory->define(ProductSelection::class, function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});

$factory->defineAs(ProductSelection::class, 'deleted', function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
        'deleted_at' => $faker->dateTimeBetween('-1 months', '-1 days'),
    ];
});

$factory->define(ProductCategorySelection::class, function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});

$factory->defineAs(ProductCategorySelection::class, 'deleted', function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
        'deleted_at' => $faker->dateTimeBetween('-1 months', '-1 days'),
    ];
});

$factory->defineAs(GammaNotification::class, 'activate', function (Faker\Generator $faker) {
    return [
        'type'       => 'activate',
        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});

$factory->defineAs(GammaNotification::class, 'deactivate', function (Faker\Generator $faker) {
    return [
        'type'       => 'deactivate',
        'created_at' => $faker->dateTimeBetween('-1 years', '-1 months'),
        'updated_at' => $faker->dateTimeBetween('-1 months', 'now'),
    ];
});