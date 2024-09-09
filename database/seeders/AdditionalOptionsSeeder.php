<?php

use Illuminate\Database\Seeder;

class AdditionalOptionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $options = [
            'interior_color' => 'Інтер\'єр',
            'transmission' => 'Коробка передач',
            'engine_name' => 'Двигун',
            'fuel_tank_capacity' => 'Об\'єм баку',
            'number_of_doors' => 'Кількість дверей',
            'cargo_volume' => 'Об\'єм вантажу',
            'engine_power' => 'Потужність двигуна',
            'features' => 'Додаткові опції',
            'latitude' => 'Широта',
            'longitude' => 'Довгота',
        ];
        
        $i = 7;
        foreach($options as $code => $item){
            
            DB::table('options')->insert([
                'name' => $item,
                'code' => $code,
                'order' => $i
                
            ]);
            $i++;
        }
        
    }

}
