<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,DB
};
use App\Components\Filters\CarFilter;
use \App\Car;
use \App\Http\Resources\OptionResource;


class RatingController  extends Controller
{
    public function index(CarFilter $filter){
        view()->share('pageTitle', __('messages.page_rating')); 
        view()->share('filters', $filter->getFilters());        
        view()->share('selectedFilters', $filter->getSelectedFilters());
        $paginate = Car::with(['options','manufacturer','model','latestStat'])->filter($filter)->paginate(20);
        
        return view('rating.index',[
            'paginate' => $paginate,
        ]);
    }
    
    
    public function getFiltersDataByVincode($vinCode){
        $record = Car::where('vincode','like',$vinCode . '%')->get()->first();        

        if($record){
            return OptionResource::make($record);
        }
        
        abort(404);
    }
    
}
