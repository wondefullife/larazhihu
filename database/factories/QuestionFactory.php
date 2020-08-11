<?php

use App\Question;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Question::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create();
            },
        'title' => $faker->sentence,
        'content' => $faker->sentence,
    ];
});

$factory->state(Question::class, 'published', function () {
    return [
        'published_at' => \Carbon\Carbon::parse('-1 day')
    ];
});

$factory->state(Question::class, 'unpublished', function () {
    return [
        'published_at' => null
    ];
});
