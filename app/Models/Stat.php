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
class Stat extends Model {
    
    public $other_properties = [];
    protected $fillable = [
        'mounth','model_id','year','count'
    ];
   
    
    
    
}
