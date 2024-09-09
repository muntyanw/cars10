<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = [
        'model','manufacturer_id','year','full_name'
    ];
    
    public function models(){
        
        return $this->hasMany(Car::class);
    }
    
      public function sales(){
        
        return $this->hasMany(Sale::class);
    }
    
    
}
