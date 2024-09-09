<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFewColumnsToCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('price')->default(null);
            $table->integer('msrp')->default(null);
            $table->text('delear_address');
            $table->boolean('is_options_set');
            $table->string('source');
            $table->string('vincode');
            $table->string('update_hash', 40);
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
            $table->dropColumn('update_hash');
            $table->dropColumn('vincode');
            $table->dropColumn('source');
            $table->dropColumn('is_options_set');
            $table->dropColumn('delear_address');
            $table->dropColumn('msrp');
            $table->dropColumn('price');
        });
    }
}
