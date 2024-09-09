<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Filters\Filterable;
//use Illuminate\Support\;
/**

 * 
 * @author AlexPetrov <alexmaoczedun@gmail.com>
 
 *  */
class Dealer extends Model {
    
    public $other_properties = [];
    protected $fillable = [
        'address','hash','geo_lat','geo_long','import_id','name','source','url','external_id'
    ];
  
    
    const SOURCE_CARS = 'cars';
    const SOURCE_CARGURU = 'carguru';
    const SOURCE_AUTOTRADER = 'autotrader';
    const SOURCE_TRUECAR = 'truecar';
   
    
    public static function findByImportIdOrCreate($importId){
        $item = Dealer::where('import_id',$importId)->first();
        
        
        if(!$item){
            $data = [
                'import_id' => $importId,
                'import_url' => "/dealers/{$importId}/"
            ];
                
            $item = self::create($data);
        }
        
        return $item->id;
        
    }
    
}
