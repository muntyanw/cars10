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
class RatingFilter extends QueryFilter {
    
    private $optionValuesConditions = [];
    //put your code here
    
    public function getFilters(){
        list($minMaxYears) = DB::select("SELECT min(year) as min_year,max(year) as max_year FROM `cars` ");
        return [
            \range($minMaxYears->min_year,$minMaxYears->max_year),
            Manufacturer::get()->toArray()
        ];
    }
    
    public function engineVolume($cargoVolume){
        $this->optionValuesConditions[] = [
            'params' => [
                'cargoVolume' => $cargoVolume
            ],
            'callback' => function($join,$params){
                $max = 0;
                $min = null;
                
                switch($params['cargoVolume']){
                    case Car::ENGINE_VOLUME_MICRO:
                        $max = 1.2;
                        break;;
                    case Car::ENGINE_VOLUME_SMALL:
                        $max = 1.8;
                        $min = 1.2;
                        break;;
                    case Car::ENGINE_VOLUME_MEDIUM:
                        $max = 3.5;
                        $min = 1.8;
                        break;;
                    case Car::ENGINE_VOLUME_LARGE:
                        $min = 3.5;
                        break;;
                }
                
                if($min){
                    $join->where("options_values.engine_volume", ">", $min);
                }
                
                if($max){
                    $join->where("options_values.engine_volume", "<=", $max);
                }
            }
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
    
    public function odo($odo){
        if(!empty($odo) && (isset($odo['start']) || isset($odo['end']))){
            $this->optionValuesConditions[] = [
                'params' => [
                    'start' => $odo['start'] ?? null,
                    'end' => $odo['end'] ?? null,
                ],
                'callback' => function($join,$params){
                    if(isset($params['start'])){
                        $this->builder->where('options_values.odo','>',$params['start']);
                    }

                    if(isset($params['end'])){
                        $this->builder->where('options_values.odo','<',$params['end']);
                    }
                }
            ];
        }
        
    }
    
    public function vin($vin){
        $this->builder->where('vincode','like','%' . $vin . '%');
    }
    
    public function mpg($value){
        if(!empty($value) && (isset($value['min']) || isset($value['max']))){
            $this->optionValuesConditions[] = [
                'params' => [
                    'min' => $value['min'] ?? null,
                    'max' => $value['max'] ?? null,
                ],
                'callback' => function($join,$params){
                    if(isset($params['min'])){
                        $this->builder->where('options_values.MGP','>',$params['min']);
                    }
                    if(isset($params['max'])){
                        $this->builder->where('options_values.MGP','<',$params['max']);
                    }
                }
            ];
        }
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
    
    public function apply($builder)
    {
        parent::apply($builder);
         
        if(!empty($this->optionValuesConditions)){
            $this->builder->join("options_values", function ($join){
                foreach ($this->optionValuesConditions as $conditionItem){
                    $conditionItem['callback']($join,$conditionItem['params']);
                }
            });
        }    
    }
    
    
    public function order($order){
        $this->builder->orderBy('price',$order);    
    }
}
