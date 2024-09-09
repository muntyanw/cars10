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
class City extends Model {
    
    public $other_properties = [];
    protected $fillable = [
        'name','state','state_id','country_flips','country_name','lat','lang','timezone','ranking','zips','import_id'
    ];
   
}
