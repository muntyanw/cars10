<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoolumnToOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options_values', function (Blueprint $table) {
            $table->string('unit');
            $table->float('number_value');
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
            $table->dropColumn('number_value');
            $table->dropColumn('unit');
        });
    }
}
