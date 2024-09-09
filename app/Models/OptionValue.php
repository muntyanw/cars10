<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**

 * 
 * @author AlexPetrov <alexmaoczedun@gmail.com>
 * @property integer $id
 * @property integer $car_id
 * @property integer $option_id
 * @property string $value
 *  */
class OptionValue extends Model {
    //
    protected $fillable = [
        'car_id','color','MGP','name','number_value','odo','odo_class','engine_volume'
    ];
    public $timestamps = false;
    protected $table = 'options_values';


    public function car(){
        
        return $this->belongsTo(Car::class);
    }
  
}
