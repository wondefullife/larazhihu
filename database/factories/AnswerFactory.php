<?php

use App\Answer;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Answer::class, function (Faker $faker) {
    return [
        'user_id' => function (){
            return factory(\App\User::class)->create()->id;
        },
        'content' => $faker->text,
        'question_id' => function (){
            return factory(\App\Question::class)->create()->id;
        }
    ];
});
