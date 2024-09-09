<?php


namespace App\Components\Filters;

use Illuminate\Support\Facades\{
    Auth,DB
};
/**
 * Description of StatFilter
 *
 * @author alexp
 */
class StatFilter extends QueryFilter {
    private $carConditions = [];
     /**
     * @param Builder $builder
     */
    //put your code here
    
    public function date($date){
        $where = [];
        
        $start = isset($date['start']) ? new \DateTime($date['start']) : null;
        $end = isset($date['end']) ? new \DateTime($date['end']) : null;
        
        $intervalInDays = $start && $end ? $start->diff($end)->days : null;
        
        $groupBy = '';
        $dbRawSelect = 'COUNT(*) as count,';
        
        
        if($intervalInDays < 21 || !$intervalInDays){ 
            $dbRawSelect .= "DAY(created_at) as day_created,concat(DAYNAME(`created_at`),' ',DAY(created_at))   as period";
            $groupBy = 'day_created';
        }
        elseif($intervalInDays < 90){

            $dbRawSelect .= "WEEK(created_at) as day_created,concat(MONTHNAME(`created_at`),' ',WEEK(created_at))  as period";
            $groupBy = 'day_created';
        }
        elseif($intervalInDays < 365){
            
            $dbRawSelect .= 'MONTHNAME(created_at) as period';
            $groupBy = 'MONTH(created_at)';
        }
        elseif($intervalInDays > 365 && $intervalInDays < 730){
            $dbRawSelect .= "CONCAT(YEAR(created_at),' ',QUARTER(created_at))  as period";
            $groupBy = 'period';
            
        }
        else{
            $dbRawSelect .= 'YEAR(created_at) as period';
            $groupBy = 'period';
        }
        
        if($start && $end){
            $this->builder->whereRaw("created_at between '{$start->format('Y-m-d')}' and '{$end->format('Y-m-d')}' ");
        }
        elseif($start){
            $this->builder->whereRaw("created_at > '{$start->format('Y-m-d')}'");
        }
        elseif($end){
            $this->builder->whereRaw("created_at < '{$end->format('Y-m-d')}'");
        }
        
        $this->builder->selectRaw($dbRawSelect)->groupBy(DB::raw($groupBy));
        
    }

    public function getSelectedFilters() {
        return [
            $this->request->input('date'),
        ];
    }
    
    public function manufacturer($manufacturer){
        $this->builder->whereHas('car', function ($query) use($manufacturer){
            $query->where('manufacturer_id', $manufacturer);
        });
    }
    
    public function traffic_acident($value){
        $this->builder->whereHas('car', function ($query){
            $query->whereRaw('is_traffic_accident = 1');
        });
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
                $this->builder->whereHas('car', function ($query) use ($ids){
                    $query->whereIn('diller_id', $ids);
                });
            } 
        }
    }
    
    public function year($year){
        if($year){
            $this->builder->whereHas('model', function ($query) use($year){
                $query->where('year', $year);
            });
        }
      
    }
    
   

}
