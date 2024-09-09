<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateGeodistFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pdo = DB::connection()->getPdo();
        
        $sqlGeodist = <<<SQL

DROP FUNCTION IF EXISTS geodist;
CREATE FUNCTION geodist (
  src_lat DECIMAL(9,6), src_lon DECIMAL(9,6),
  dst_lat DECIMAL(9,6), dst_lon DECIMAL(9,6)
) RETURNS DECIMAL(6,2) DETERMINISTIC
BEGIN
 SET @dist := 6371 * 2 * ASIN(SQRT(
      POWER(SIN((src_lat - ABS(dst_lat)) * PI()/180 / 2), 2) +
      COS(src_lat * PI()/180) *
      COS(ABS(dst_lat) * PI()/180) *
      POWER(SIN((src_lon - dst_lon) * PI()/180 / 2), 2)
    ));
 RETURN @dist;
END             
SQL;
        $pdo->exec($sqlGeodist);
        
        $sqlGeodistPt = <<<SQL

DROP FUNCTION IF EXISTS geodist_pt;
CREATE FUNCTION geodist_pt (src POINT, dst POINT) 
RETURNS DECIMAL(6,2) DETERMINISTIC
BEGIN
  RETURN geodist(X(src), Y(src), X(dst), Y(dst));
END  
SQL;
        $pdo->exec($sqlGeodistPt);
        
   
        
        $sqlGeoboxPt = <<<SQL

DROP PROCEDURE IF EXISTS geobox_pt;
CREATE PROCEDURE geobox_pt (
    IN pt POINT, IN dist DECIMAL(6,2),
    OUT top_lft POINT, OUT bot_rgt POINT
) DETERMINISTIC
BEGIN

  CALL geobox(X(pt), Y(pt), dist, @lat_top, @lon_lft, @lat_bot, @lon_rgt);
  SET top_lft := POINT(@lat_top, @lon_lft);
  SET bot_rgt := POINT(@lat_bot, @lon_rgt);
END
SQL;
        $pdo->exec($sqlGeoboxPt);
        
        $sqlProcedureGeobox = <<<SQL

DROP PROCEDURE IF EXISTS geobox;
CREATE PROCEDURE geobox (
  IN src_lat DECIMAL(9,6), IN src_lon DECIMAL(9,6), IN dist DECIMAL(6,2),
  OUT lat_top DECIMAL(9,6), OUT lon_lft DECIMAL(9,6),
  OUT lat_bot DECIMAL(9,6), OUT lon_rgt DECIMAL(9,6)
) DETERMINISTIC
BEGIN
  SET lat_top := src_lat + (dist / 69);
  SET lon_lft := src_lon - (dist / ABS(COS(RADIANS(src_lat)) * 69));
  SET lat_bot := src_lat - (dist / 69);
  SET lon_rgt := src_lon + (dist / ABS(COS(RADIANS(src_lat)) * 69));
END        
                
SQL;
        $pdo->exec($sqlProcedureGeobox);
        
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            $sql = <<<SQL
DROP PROCEDURE IF EXISTS geobox;
DROP PROCEDURE IF EXISTS geobox_pt;
DROP FUNCTION IF EXISTS geodist_pt;
DROP FUNCTION IF EXISTS geodist;
                
SQL;
        
        DB::connection()->getPdo()->exec($sql);
    }
}
