<?php
namespace App\Components\Filters;

use Illuminate\Http\Request;
use App\Car;

/**
 * 
 * @property Illuminate\Http\Request $request
 * @property Illuminate\Database\Eloquent\Builder $builder
 * 
 *  */
abstract class QueryFilter
{
    protected $optionValuesConditions = [];
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract public function getSelectedFilters();
    /**
     * @param Builder $builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->fields() as $field => $value) {
            $method = $field;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        
        if(!empty($this->optionValuesConditions)){
            $this->builder->join("options_values",'cars.id','=','options_values.car_id');
            
            foreach ($this->optionValuesConditions as $conditionItem){
                $conditionItem['callback']($conditionItem['params']);
            }
        }
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        $fields = $this->request->all();

        foreach($fields as $key => $val){
            if(is_null($val) || (is_array($val) && count($val) === 0)){
                unset($fields[$key]);
            }
        }
        return $fields;
    }
    
        
    public function mpg($value){
        if(!empty($value) && (isset($value['min']) || isset($value['max']))){
            $this->optionValuesConditions[] = [
                'params' => [
                    'min' => $value['min'] ?? null,
                    'max' => $value['max'] ?? null,
                ],
                'callback' => function($params){
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
    
    public function odo($odo){
        if(!empty($odo) && (isset($odo['start']) || isset($odo['end']))){
            $this->optionValuesConditions[] = [
                'params' => [
                    'start' => $odo['start'] ?? null,
                    'end' => $odo['end'] ?? null,
                ],
                'callback' => function($params){
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
    
    public function engineVolume($cargoVolume){
        $this->optionValuesConditions[] = [
            'params' => [
                'cargoVolume' => $cargoVolume
            ],
            'callback' => function($params){
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
                
                
                if(isset($params['start'])){
                    $this->builder->where('options_values.odo','>',$params['start']);
                }

                if(isset($params['end'])){
                    $this->builder->where('options_values.odo','<',$params['end']);
                }
            }
        ];
    }
    
    public function color($color){
         if(isset($color)){
            $this->optionValuesConditions[] = [
                'params' => [
                    'color' => $color,
                ],
                'callback' => function($params){
                    $this->builder->where('options_values.color',$params['color']);
                }
            ];
        }
    }
    
    public function price($price){
        if(isset($price['min'],$price['max'])){
            $this->builder->whereBetween('price',[$price['min'],$price['max']]);
        }
        elseif(isset($price['min'])){
            $this->builder->where('price','>',$price['min']);
        }
        elseif(isset($price['max'])){
            $this->builder->where('price','<',$price['max']);
        }
    }
    
    public function model($model){
        if($model && is_numeric($model)){
            $this->builder->where('model_id',$model);
        }
    }
     
    
    public function traffic_acident($value){
        $this->builder->whereRaw('is_traffic_accident = 1');
    }
    
    public function number_of_owners($value){
        $this->builder->where('number_of_owners',$value);
    }
    
    
}