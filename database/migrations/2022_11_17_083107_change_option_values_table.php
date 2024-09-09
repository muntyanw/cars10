<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options_values', function (Blueprint $table) {
            $table->string('color')->default(null);
            $table->float('engine_volume')->default(null);
            $table->integer('odo')->default(null);
            $table->integer('MGP')->default(null);
            $table->integer('CR')->default(null);
            
            $table->dropColumn('unit');
            $table->dropColumn('number_value');
            
        });
        
        Schema::table('cars', function (Blueprint $table) {
            $table->json('properties')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('other_properties');
        });
        
        Schema::table('options_values', function (Blueprint $table) {
            $table->string('unit');
            $table->float('number_value');
            
            $table->dropColumn('CR');
            $table->dropColumn('MGP');
            $table->dropColumn('odo');
            $table->dropColumn('engineVolume');
            $table->dropColumn('color');
        });
        
    }
}
