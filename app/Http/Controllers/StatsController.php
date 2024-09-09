<?php
namespace App\Http\Controllers;

use App\Components\Filters\CarFilter;

use Illuminate\Support\Facades\{
    Auth,DB
};
use \App\Sale;

use App\Services\StatService;
use \App\Components\Filters\StatFilter;
use Illuminate\Database\Query\Builder;

class StatsController  extends Controller{
    public function index(StatService $service,StatFilter $filter){
        if (!Auth::check()) {
            return redirect('/login');
        }
//                DB::enableQueryLog();
        $res = Sale::with(['car','options','model'])->filter($filter)->pluck('count', 'period');;
//        
//        $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
//                    ->whereYear('created_at', date('Y'))
//                    ->groupBy(DB::raw("Month(created_at)"))
//                    ->pluck('count', 'month_name');

        $labels = $res->keys();
        $values = $res->values();
//        Неделя
//        SELECT COUNT(*) as count,DAYNAME(`created_at`) as day
//FROM `sales`
//group by DAY(created_at)
//LIMIT 550
 
        
        
//         SELECT COUNT(*) as count,WEEK(created_at) as weeknumber
//FROM `sales`
//group by WEEK(created_at)
//LIMIT 550
        
        
         return response()->json([
            
            'labels' => $labels,
            'values' => $values,
            
        ]);

        
    }
    
    
    
    
}
