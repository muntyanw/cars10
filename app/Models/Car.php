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
class Car extends Model {
    
    public $other_properties = [];
    
    protected $fillable = [
        'model_id','properties','page_number','position_on_page'
    ];
    
    protected $casts = [
        'properties' => 'array',
    ];
    
    use Filterable;
    //
    const ODO_CLASS_UNDEFINED = 0;
    const ODO_CLASS_XSMALL = 1;
    const ODO_CLASS_SMALL = 2;
    const ODO_CLASS_MEDIUM = 3;
    const ODO_CLASS_BIG = 4;
    const ODO_CLASS_HUGE = 5;
    const ODO_CLASS_IMMENSE = 6;
    
    const ENGINE_VOLUME_MICRO = 0;
    const ENGINE_VOLUME_SMALL = 1;
    const ENGINE_VOLUME_MEDIUM = 2;
    const ENGINE_VOLUME_LARGE = 3;
    
    const SOURCE_CARS = 'cars';
    const SOURCE_CARGURU = 'carguru';
    const SOURCE_TRUECAR = 'truecar';
    const SOURCE_AUTOTRADE = 'autotade';
    
    public function options(){
        
        return $this->hasOne(OptionValue::class);
    }
    
    public function getSourceUrl(){
        
    }
    
    public function latestStat()
    {
        $month = \date('n');
        $year = \date('Y');
        
        
        return $this->hasOne(Stat::class,'model_id','model_id')->where('year',$year)->where('mounth',$month);
    }
    
    public function stats(){
        
        return $this->hasMany(Stat::class,'model_id','model_id');
    }

    public function images(){
        
        return $this->hasMany(CarImage::class,'car_id');
    }
    
    public function manufacturer(){
        
        return $this->belongsTo(Manufacturer::class);
    }
    
    public function model(){
        
        return $this->belongsTo(CarModel::class);
    }
    
    public function Dealer(){
        
        return $this->belongsTo(Dealer::class,'diller_id');
    }
    
    public function setPropertiesAttribute($value){
        $this->attributes['properties'] = json_encode($value);
    }
    
    
    public static function getOdoClassByOdo($odo){
        
        $class = self::ODO_CLASS_UNDEFINED;
        if($odo < 50000){
            $class = self::ODO_CLASS_XSMALL;
        }
        elseif($odo < 100000){
            $class = self::ODO_CLASS_SMALL;
        }
        elseif($odo < 150000){
            $class = self::ODO_CLASS_MEDIUM;
        }
        elseif($odo < 200000){
            $class = self::ODO_CLASS_BIG;
        }
        elseif($odo < 250000){
            $class = self::ODO_CLASS_HUGE;
        }
        elseif($odo < 300000){
            $class = self::ODO_CLASS_IMMENSE;
        }
        return $class;
        
    }
    
}
