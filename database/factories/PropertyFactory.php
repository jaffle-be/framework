<?php

use Modules\Shop\Product\Property;
use Modules\Shop\Product\PropertyOption;
use Modules\Shop\Product\PropertyUnit;
use Modules\Shop\Product\PropertyValue;

$factory->define(Property::class, function (Faker\Generator $faker) {

    $types = ['string', 'numeric', 'float', 'option', 'boolean'];
    $type = array_rand($types);
    $type = $types[$type];

    $name = $faker->word;

    return [
        'type' => $type,
        'nl' => [
            'name' => $name,
        ],
        'en' => [
            'name' => $name,
        ]
    ];
});

$factory->defineAs(Property::class, 'boolean', function (Faker\Generator $faker) use ($factory){
    $property = $factory->raw(Property::class);
    return array_merge($property, ['type' => 'boolean']);
});

$factory->defineAs(Property::class, 'numeric', function (Faker\Generator $faker) use ($factory){
    $property = $factory->raw(Property::class);
    return array_merge($property, ['type' => 'numeric']);
});

$factory->defineAs(Property::class, 'float', function (Faker\Generator $faker) use ($factory){
    $property = $factory->raw(Property::class);
    return array_merge($property, ['type' => 'float']);
});

$factory->defineAs(Property::class, 'string', function (Faker\Generator $faker) use ($factory){
    $property = $factory->raw(Property::class);
    return array_merge($property, ['type' => 'string']);
});

$factory->defineAs(Property::class, 'options', function (Faker\Generator $faker) use ($factory){
    $property = $factory->raw(Property::class);
    return array_merge($property, ['type' => 'options']);
});


$factory->define(PropertyOption::class, function (Faker\Generator $faker) {
    $name = $faker->lastName;

    return [
        'nl' => [
            'name' => $name,
        ],
        'en' => [
            'name' => $name,
        ],
    ];
});

$factory->define(PropertyValue::class, function (Faker\Generator $faker) {
    $string = $faker->colorName;
    return [
        'boolean' => rand(0,1),
        'numeric' => $faker->numberBetween(0, 100),
        'float' => $faker->randomFloat(),
        'nl' => [
            'string' => $string,
        ],
        'en' => [
            'string' => $string,
        ],
    ];
});


$factory->define(PropertyUnit::class, function (Faker\Generator $faker) {
    $name = $faker->firstName;
    return [
        'nl' => [
            'name' => $name,
            'unit' => $name,
        ],
        'en' => [
            'name' => $name,
            'unit' => $name,
        ],
    ];
});


