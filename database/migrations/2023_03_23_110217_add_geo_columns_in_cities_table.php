<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeoColumnsInCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            
            $pdo = DB::connection()->getPdo();
        
        $sql = <<<SQL
                ALTER TABLE cities ADD COLUMN `lang` DECIMAL(9,6)
                
SQL;
        $pdo->exec($sql);
        
        $sql = <<<SQL
                ALTER TABLE cities ADD COLUMN `lat` DECIMAL(9,6)
                
SQL;
        
            $pdo->exec($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $pdo = DB::connection()->getPdo();
        
        $sql = <<<SQL
                ALTER TABLE cities DROP COLUMN `lang` 
                
SQL;
        $pdo->exec($sql);
        
        $sql = <<<SQL
                ALTER TABLE cities DROP COLUMN `lat` 
                
SQL;
        
            $pdo->exec($sql);
            
            //
        });
    }
}
