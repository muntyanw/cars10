<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dillers', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('hash')->nullable();
            $table->string('geo_lat')->nullable();
            $table->string('geo_long')->nullable();
            $table->string('import_id')->nullable();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('import_url')->nullable();
            $table->enum('source', ['cars','carguru','autotrader']);
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dillers');
    }
}
