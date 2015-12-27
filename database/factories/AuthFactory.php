<?php

use Modules\Users\Auth\Tokens\Token;

$factory->define(Token::class, function (Faker\Generator $faker) {
    return [
        'type' => array_rand([Token::TYPE_RESET, Token::TYPE_CONFIRMATION], 1),
        'value' => app('hash')->make($faker->userName),
        'expires_at' => $faker->dateTimeBetween('now', '+14 days'),
    ];
});

$factory->defineAs(Token::class, 'reset', function (Faker\Generator $faker) {
    return [
        'type' => Token::TYPE_RESET,
        'value' => app('hash')->make($faker->userName),
        'expires_at' => $faker->dateTimeBetween('now', '+14 days'),
    ];
});

$factory->defineAs(Token::class, 'confirm', function (Faker\Generator $faker) {
    return [
        'type' => Token::TYPE_CONFIRMATION,
        'value' => app('hash')->make($faker->userName),
        'expires_at' => $faker->dateTimeBetween('now', '+14 days'),
    ];
});
