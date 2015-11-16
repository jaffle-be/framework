<?php

$factory->define(Modules\Users\User::class, function (Faker\Generator $faker) {
    return [
        'firstname'      => $faker->firstName,
        'lastname'       => $faker->lastName,
        'email'          => $faker->email,
        'password'       => \Hash::make('thomas'),
        'remember_token' => str_random(10),
        'confirmed'      => 1,
        'phone'          => $faker->phoneNumber,
        'vat'            => '123456789121',
        'website'        => $faker->domainName,
    ];
});