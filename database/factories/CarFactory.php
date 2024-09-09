<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    
    $price = mt_rand(10000,100000);
    $msrp = null;
    
    if(mt_rand(0,100) & 1){
        $msrp = $price +  mt_rand(100,2500);
    }
    else{
        $msrp = $price -  mt_rand(100,2500);
    }
    
    return [
        'page_number' => mt_rand(1,100),
        'position_on_page' => mt_rand(1,50),
        'is_traffic_accident' => mt_rand(0,1),
        'price' => $price,
        'msrp' => $msrp,
        'source' => $faker->randomElements([Car::SOURCE_CARGURU,Car::SOURCE_CARS])[0],
        'url' =>  $faker->lexify(),
        'vincode' =>  $faker->bothify('?##?#?###?##??#????#'),
        'manufacturer_id' => mt_rand(10,250),
        'diller_id' => mt_rand(1,40),
        'model_id' => mt_rand(1,20000),
    ];
});
