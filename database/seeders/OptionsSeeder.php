<?php

use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $options = [
            'color' => 'Колір',
            'engine_volume' => 'Об\'єм двигуна',
            'fuel_type'  => 'Топливо',
            'odo' => 'Пробіг',
            'traffic_acident' => 'ДТП',
            'drivetrain' => 'Привод',
        ];
        
        $i = 0;
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
