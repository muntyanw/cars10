<?php

use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $options = [
            'Audi',
            'BMW',
            'Chevrolet',
            'Ford',
            'Honda',
            'Mercedes-benz'
        ];
        
        foreach($options as  $item){
            
            DB::table('manufacturers')->insert([
                'name' => $item,
            ]);
        }
    }
}
