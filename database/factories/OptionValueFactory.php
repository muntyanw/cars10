<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OptionValue;
use Faker\Generator as Faker;

$factory->define(OptionValue::class, function (Faker $faker) {
    $str = 'Dolomite Silver Metallic, Black, Black Sapphire, Mineral Gray, Bluestone, Alpine White, Nardo Gray, Alpine White, Black Sapphire, Alpine White, Obsidian Black, Blue Metallic, Alpine White, Alpine White, SKYSKRAPER, Deep Black Pearl Effect, 0223, 0085, Black, Nebula Gray Pearl, Deep Cherry Red Crystal Pearlcoat, Ice White, Glacier White Metallic, Glacier White Metallic, Ibis White, Daytona Gray Pearl Effect, Navarra Blue Metallic, Glacier White Metallic, Mythos Black Metallic, Ibis White, Phantom Black, Portofino Gray, Red, Shimmering Silver, Portofino Gray, White, Gunmetal Metallic, Midnight Silver Metallic, Midnight Silver Metallic, Fuji White, Eiger Grey, Glacier White, Hermosa Blue, Lead Foot, Sonic Gray Pearl, Sonic Gray Pearl, Sonic Gray Pearl, Nebula Gray Pearl, Radiant Red Metallic II, Quicksilver Metallic, Glacier White Metallic, Lunar Silver Metallic, Octane Red Pearlcoat, Silver Zynith, F8 Green Clearcoat, White Knuckle Clearcoat, Sinamon Stick, Limited Edition Gobi Clearcoat, Mythos Black, Crystal White Pearl Metallic, Selenite Gray Metallic, Crystal White Metallic, Cosmos Blue Metallic, Deep Black Metallic, Nero, Cosmos Blue Metallic, Iridium Silver Metallic, Midnight Blue Metallic, Torch Red, Dark Gray Metallic, Predawn Gray Mica, Oxford White, Agate Black Metallic, Black, Corris Gray Metallic, Red, Quartz Blue Pearl, Magnetite Gray Metallic, Lunar Silver Metallic, Ingot Silver, Soul Red Metallic, Crystal Black Pearl, Black Sapphire, 0223, Deep Black Pearl Effect, Black Sapphire, Lunar Silver Metallic, Modern Steel Metallic, Crimson Red Pearl, DB Black Crystal Clearcoat, Crystal Black Pearl, Birch Light Metallic, Denim Blue Metallic, Antimatter Blue Metallic, Black Diamond Pearl, Silver Metallic, Light Gray, Bright White Clearcoat, White Knuckle Clearcoat, Bright White Clearcoat, Soul Red Crystal Metallic, White, Opal White Pearl Effect, Mountain Air Metallic, Grigio, Rosso, Glacier White Metallic, Summit White, British Racing Green, Iridium, Black, Cyber Orange Metallic Tricoat, Diamond Red, Pure White, Summit White, Starling Blue Metallic, Diamond White, Nebula Gray Pearl, Atomic Silver, Caviar, Diamond White, Patagonia Red, Midnight Black, Star White, Graphite, White, Off White, Silver Metallic, Lunar Blue Metallic, –, Bright White Clearcoat, Agate Black Metallic, Mosaic Black Metallic, Star White Metallic Tri-Coat, Chronos Gray Metallic, Black, Pure White, Savile Silver, Frozen Black, Platinum White Pearl, Imperial Blue Metallic, Meteorite Gray Metallic, Octane Red Pearlcoat, Ceramic Gray Clearcoat, Atomic Silver, Diamond Black, Silver Zynith, Deep Black Pearl Effect, Magnetic Black, Geyser Blue, Black Raven, Bianco, Black Raven, Midnight Black, Alpine White, Black, Santorini Black Metallic, Starling Blue Metallic';
    $colors = explode(',', $str);
    return [
        'car_id' => mt_rand(1,1000),
        'color' => $faker->randomElements($colors)[0],
        'engine_volume' => $faker->randomFloat(1,1,6),
        'odo' => $faker->randomFloat(1,1,6),
        'MGP' => $faker->randomFloat(1,1,6),
        'CR' => $faker->randomFloat(1,1,5),
    ];
});
