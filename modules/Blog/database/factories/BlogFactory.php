<?php

$factory->define(Modules\Blog\Post::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(Modules\Blog\PostTranslation::class, function (Faker\Generator $faker) {
    return [
        'locale' => 'en',
        'title' => $faker->title,
        'content' => $faker->realText(),
        'cached_content' => $faker->realText(),
        'cached_extract' => $faker->realText(),
        'publish_at' => $faker->dateTimeBetween('-1 years', '-1 days'),
    ];
});
