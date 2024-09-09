<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Filters\Filterable;
//use Illuminate\Support\;
/**

 * 
 * @author AlexPetrov <alexmaoczedun@gmail.com>
 * @property integer $id
 * @property string $model
 * @property string $location
 * @property integer $cr
 *  */
class GeoData extends Model {
    
    public $other_properties = [];
    
    protected $fillable = [
        'country',
        'iso_code',
        'ip',
        'city',
        'state',
        'state_name',
        'postal_code',
        'lat',
        'lon',
        'timezone',
        'continent',
        'currency',
        'user_id',
    ];
    
    
     public function user(){
        
        return $this->belongsTo(User::class,'user_id');
    }
    
    
    
}
