<?php

use App\Models\Answer;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Answer::class, function (Faker $faker) {
    return [
        'user_id' => function (){
            return factory(\App\Models\User::class)->create()->id;
        },
        'content' => $faker->text,
        'question_id' => function (){
            return factory(\App\Models\Question::class)->create()->id;
        }
    ];
});
