<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CarImage;
use Faker\Generator as Faker;

$factory->define(CarImage::class, function (Faker $faker) {
    return [
        'car_id' => mt_rand(1,10000),
        'src' => $faker->bothify('?##?#?###?##??#????#'),
    ];
});
