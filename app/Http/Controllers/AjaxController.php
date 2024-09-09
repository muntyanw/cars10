<?php
namespace App\Http\Controllers;

use App\Components\Filters\CarFilter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,Route,DB
};

class AjaxController  extends Controller{
    
    
    public function cities($state){

        $cities = DB::table('cities')->select(DB::raw('name,country_name,CONCAT(name,", ",country_name) as full_name,CONCAT(lang,",",lat) as geo'))
                                    ->orderBy('country_name')
                                    ->orderBy('name')
                                    ->where('state',$state)
                                    ->pluck('full_name','geo');
        
        return response()->json([
            'data' => $cities
        ]);

    }
    
    public function models($man){

        $models = DB::table('car_models')->select(DB::raw('id,CONCAT(model," ",year) as model'))
                                    ->orderBy('model')
                                    ->where('manufacturer_id',$man)
                                    ->pluck('model','id');
        
        return response()->json([
            'data' => $models
        ]);

    }
   
}
