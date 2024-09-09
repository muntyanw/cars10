<?php


namespace App;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of ModelPrice
 *
 * @author alexp
 */
class ModelPrice extends Model{
    
    private $table;
    
    //put your code here
    //put your code here
    protected $fillable = [
        'model_id','price_carguru','price_cars','price_autotrader','odo_class'
    ];
    
    
    public function model(){
        return $this->belongsTo(CarModel::class,'model_id');
    }
    
}
