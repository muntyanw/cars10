<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stat;
use Faker\Generator as Faker;

$factory->define(Stat::class, function (Faker $faker) {    
    return [
        'mounth' => mt_rand(1,12),
        'model_id' => mt_rand(1,20000),
        'car_id' => mt_rand(1,20000),
        'year' => mt_rand(2017,2023),
        'count' => mt_rand(1,100),
    ];
});
