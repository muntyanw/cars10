<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**

 * 
 * @author AlexPetrov <alexmaoczedun@gmail.com>
 * @property integer $id
 * @property string $model
 * @property string $location
 * @property integer $cr
 *  */
class Manufacturer extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

      public function cars(){
        
        return $this->hasMany(Car::class);
    }
}
