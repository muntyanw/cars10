<?php
namespace App\Http\Controllers;

use App\Components\Filters\CarFilter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,Route,DB
};
use \App\{
    Car,
    Manufacturer,
    Option,
    Dealer,
    Test,
    Sale,
    OptionValue
};

use App\Services\StatService;
use Faker\Generator as Faker;

class CarsController  extends Controller{
    
    public function search(StatService $service,CarFilter $filter){
        
        view()->share('pageTitle', __('messages.page_search'));
        view()->share('filters', $filter->getFilters());        
        view()->share('selectedFilters', $filter->getSelectedFilters());      
        $cars = Car::with(['options','manufacturer','model'])->filter($filter)->limit(20)->get()->toArray();
        
        return view('main.index',[
            'cars' => $cars,
        ]);
    }
    
    public function index(StatService $service,CarFilter $filter,Request $request){
        if (!Auth::check()) {
            return redirect('/login');
        }
         
        view()->share('pageTitle', __('messages.main_page'));        
        view()->share('filters', $filter->getFilters());        
        view()->share('selectedFilters', $filter->getSelectedFilters());   
        DB::enableQueryLog();
        $paginate = Car::with(['options','manufacturer','model'])->filter($filter)->paginate(20);
        $queries = DB::getQueryLog();
        
        
        if($request->ajax()){
           return response()->json([
               'items' => $paginate->toArray()['data'],
               'nextPage' => $paginate->nextPageUrl(),
           ]);
        }
        
        
        
        return view('main.index',[
            'paginate' => $paginate,
        ]);
    }
    
    public function view($id){
        $car = Car::with(['options','images'])->find($id);
        
        $pageTitle = '';
        
        if($car->model){
            $pageTitle = $car->model->model . ' ' . $car->model->year;
        }
                
        view()->share('pageTitle', $pageTitle);
        
        return view('main.view',[
            'car' => $car,
        ]);
    }
    
    
    public function test(Faker $faker){
//        $cars = Car::take(50)->get();
//        
//        
//        $cars = $cars->reject(function ($car) {
//            return $car->year == 2022;
//        });
        
          
        
        $cars = Car::cursor()->filter(function ($car) {
            return $car->id === 2022;
        });
        
    foreach($cars as $carItem){
      echo  $carItem->year;
    };
        
//        dd($cars);
        exit();
        
        
//        dd($cars);
//        exit();
        
//        dd(DB::table('options_values')->selectRaw("DISTINCT color")->whereRaw('color is not null')->pluck('color'));
//        dd(OptionValue::dis);
//            $car = Sale::with(['car'])->find(8);
//            dd($car);
//            exit();
//        Sale::f
//        echo strtotime('first day of january this year');
//        exit();
//        vd($faker->dateTimeBetween('-2 years','now')->format('Y-m-d H:i:s'));
////        echo ;
//        exit();
//        DB::enableQueryLog();
////        DB::table('cities');
//        $res = DB::table('Dealers')->whereRaw(DB::raw("(
//    ST_Distance_Sphere(
//      point(`geo_long`, `geo_lat`),  
//      point(-87.863600, 41.903000)
//    ) *.000621371192
//  ) <= 50"))->pluck('id');
//        dd($res);
////        dd(\DB::getQueryLog());
//        
////       ;
////        Car::with(['latestStat:count'])->find(7574);
////        dd( Car::with(['latestStat'])->find(7574)->latestStat);
////        dd(\date('n'));
//        exit();
//        echo __LINE__;exit();
        
        
    }
    

}
