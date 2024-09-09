<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDillersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
//        $table->enum('source', ['cars','carguru','autotrader']);
        Schema::table('dillers', function (Blueprint $table) {
            
            $table->dropColumn('source');
            $table->dropColumn('external_id');
        });
        Schema::table('dillers', function (Blueprint $table) {
            
            $table->enum('source', ['cars','carguru','autotrader','truecar']);
        });
        Schema::rename('dillers', 'dealers');

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::rename('dealers','dillers');
    }
}
