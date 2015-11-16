<?php

$factory->define(Modules\Account\Account::class, function (Faker\Generator $faker) {
    return [
        'alias'  => $faker->userName(),
        'domain' => $faker->domainName,
    ];
});