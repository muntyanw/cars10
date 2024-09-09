<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CarModel;
use Faker\Generator as Faker;

$factory->define(CarModel::class, function (Faker $faker) {
   return [
        'model' => 'Model' . mt_rand(1,1000),
        'manufacturer_id' => mt_rand(1,1000),
        'year' => mt_rand(1985,2023),
       
    ];
});
