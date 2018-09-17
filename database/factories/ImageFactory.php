<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
    return [
        'imageUrl' => $faker->imageUrl($width = 640, $height = 480),
        'gallery_id' => $faker->numberBetween($max= 25 , $min = 1),
    ];
});
