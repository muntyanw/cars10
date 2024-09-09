<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewChangeOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options_values', function (Blueprint $table) {
            $table->dropColumn('MGP');
            $table->dropColumn('CR');
        });
        Schema::table('options_values', function (Blueprint $table) {
            $table->float('MGP')->default(null);
            $table->float('CR')->default(null);
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         
        Schema::table('options_values', function (Blueprint $table) {
            $table->dropColumn('MGP');
            $table->dropColumn('CR');
        });
        Schema::table('options_values', function (Blueprint $table) {
            $table->integer('MGP')->default(null);
            $table->integer('CR')->default(null);
        });
        //
    }
}
