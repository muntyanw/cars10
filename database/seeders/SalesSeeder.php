<?php

use Illuminate\Database\Seeder;
use App\Sale;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Sale::factory()->count(4)->create();
    }
}
