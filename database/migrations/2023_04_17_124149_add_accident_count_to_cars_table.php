<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccidentCountToCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->smallInteger('accident_count')->nullable();
        });
        Schema::table('dillers', function (Blueprint $table) {
            $table->string('external_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('dillers', function (Blueprint $table) {
            $table->dropColumn('external_id');
        });
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('accident_count');
        });
    }
}
