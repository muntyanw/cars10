<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sale;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {  
    $dateTime = $faker->dateTimeBetween('-4 years','now');
    
    return [

        'created_at' => $dateTime->format('Y-m-d H:i:s'),
        'date' =>  $dateTime->getTimestamp(),
        'model_id' => mt_rand(1,20000),
        'car_id' => mt_rand(1,22),
    ];
});
