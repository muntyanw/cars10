<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteUnused extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('options');
        Schema::table('options_values', function (Blueprint $table) {
            $table->dropColumn('number_value');
            $table->dropColumn('unit');
            $table->dropColumn('option_id');
            $table->dropColumn('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('options_values', function (Blueprint $table) {
            $table->string('unit');
            $table->float('number_value');
            $table->integer('option_id');
            $table->text('value');
        });
        
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('order');
        });
    }
}
