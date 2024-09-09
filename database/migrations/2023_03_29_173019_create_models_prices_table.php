<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id');
            $table->integer('price_carguru');
            $table->integer('price_cars');
            $table->integer('price_autotrader');
            $table->smallInteger('odo_class');
            $table->timestamps();
        });
        
        Schema::table('options_values', function (Blueprint $table) {
            $table->smallInteger('odo_class');
        });
        
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('delear_address');
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
            $table->text('delear_address');
        });
        Schema::table('options_values', function (Blueprint $table) {
            $table->dropColumn('odo_class');
        });
        Schema::dropIfExists('models_prices');
    }
}
