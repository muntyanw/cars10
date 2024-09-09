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
class Sale extends Model {
    use Filterable;
    
    protected $fillable = [
        'date','model_id','car_id',
    ];
    
    public function model(){
        
        return $this->belongsTo(CarModel::class);
    }
    
    public function car(){
        
        return $this->belongsTo(Car::class,'car_id');
    }
    
    public function options(){
        
        return $this->hasOne(OptionValue::class,'car_id');
    }
    
    
}
