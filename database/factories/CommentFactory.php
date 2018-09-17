<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->text($maxNbChars = 1000),
        'user_id' => $faker->numberBetween($max= 10 , $min = 1),
        'gallery_id' => $faker->numberBetween($max= 25 , $min = 1),
    ];
});
