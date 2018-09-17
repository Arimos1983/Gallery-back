<?php

use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'name' => $faker->text($maxNbChars = 100, $minNbChars = 2),
        'description' => $faker->text($maxNbChars = 1000),
        'user_id' => $faker->numberBetween($max= 10 , $min = 1),
    ];
});
