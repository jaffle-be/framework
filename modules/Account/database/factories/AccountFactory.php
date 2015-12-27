<?php

$factory->define(Modules\Account\Account::class, function (Faker\Generator $faker) {
    return [
        'alias' => $faker->unique()->userName(),
        'domain' => $faker->domainName,
    ];
});
