<?php

namespace App\Components\Filters;
use Illuminate\Support\Facades\{
    DB
};
use \App\{
    Manufacturer,
    Car
};
/**
 * Description of CarFilter
 *
 * @author alexp
 */
class CarFilter extends QueryFilter {
    //put your code here
    
    public function getFilters(){
        list($minMaxYears) = DB::select("SELECT min(year) as min_year,max(year) as max_year FROM `car_models` ");
        
        return [
            \range($minMaxYears->min_year,$minMaxYears->max_year),
            Manufacturer::get()->toArray(),
            DB::select("SELECT state FROM `cities`"),
            DB::table('options_values')->selectRaw("DISTINCT color")->whereRaw('color is not null')->pluck('color')
        ];
    }
    
    
    public function year($year){
        if($year){
            $this->builder->where('year',$year);
        }
    }
    
    public function manufacturer($manufacturer){
        $this->builder->where('manufacturer_id',$manufacturer );
    }
    
    public function vin($vin){
        $this->builder->where('vincode','like','%' . $vin . '%');
    }

    public function getSelectedFilters() {
        return [
            $this->request->input('manufacturer'),
            $this->request->input('year'),
            $this->request->input('cargoVolume'),
            $this->request->input('vin'),
            $this->request->input('mpg'),
            $this->request->input('odo'),
            $this->request->input('order'),
        ];
    }
    
   
    
    
    public function order($order){
        $this->builder->orderBy('price',$order);    
    }
    
    public function geo($geo){
        if(isset($geo['city'],$geo['radius'])){
            
            $sql = <<<SQL
        (
        ST_Distance_Sphere(
          point(`geo_long`, `geo_lat`),  
          point({$geo['city']})
        ) *.000621371192
      ) <= {$geo['radius']}            
SQL;

            $ids = DB::table('dealers')->whereRaw(DB::raw($sql))->pluck('id');
            
            if(count($ids)){
                $this->builder->whereIn('diller_id', $ids);
            }
            
            
            
        }
    }
    
    
  
}
