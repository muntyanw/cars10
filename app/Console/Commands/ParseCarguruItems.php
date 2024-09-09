<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

use App\{
    Manufacturer,
    Car,
    CarModel,
    Dealer
};

//Cars.com
//Cargurus.com
//Auto trader.com
//Carfax.com
//True at.com
//
//Truecar.com
//
//Это Николай скинул площадки
//
//Auto auction 
//Manheim.com
//Log in : Nestlight
//Password: peter77
//Adesa.com
//America’s auto auction.com

// https://www.truecar.com/used-cars-for-sale/listing/1FMCU0GXXDUA30394/2013-ford-escape/


/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseCarguruItems extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:carguru-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
//        \s-\s\$\d+,\d+
        
        $time_start = microtime(true);
         
        
        $manufacturerMap = [];
        foreach(Manufacturer::distinct()->get()->toArray() as $item){
            $manufacturerMap[strtolower($item['name'])] = $item['id'];
        }
//        $this->normilizaManufacturers($manufacturerMap);
        
        
        $modelsMap = DB::table('car_models')->selectRaw("LOWER(CONCAT(`model`,'_',`year`,'_',`manufacturer_id`)) as model,`id`")->pluck('id','model');;
       
        $dealersMap = DB::table('dealers')->selectRaw("import_id,id")->whereRaw("import_id is not null")->pluck('import_id','id')->toArray();;
       
        function getDealer($sellerInfo,&$dealersMap){
            
            $externalId =  $sellerInfo['listingSellerId'];
            
            if(!isset($dealersMap[$externalId])){
                $geo = $sellerInfo['address']['geo'];
                
                $dealer = new Dealer();
                $dealer->hash = md5($sellerInfo['name']);
                $dealer->name = $sellerInfo['name'];
                $dealer->import_id = $externalId;
                $dealer->address = implode(', ', $sellerInfo['address']['addressLines']);
                $dealer->geo_lat = $geo['latitude'];
                $dealer->geo_long = $geo['longitude'];
                $dealer->url = $sellerInfo['websiteDomain'];
                $dealer->source = Dealer::SOURCE_CARGURU;
                
                
                $dealer->save();
                
                $dealersMap[$externalId] = $dealer->id;
                
            }
            
            return $dealersMap[$externalId];
            
        }
        
        function getModel($year,$title,$manufacturerId,&$modelsMap){
            $manName = explode(' ',$title)[1];
            
            $lower = strtolower("{$title}_{$year}_{$manufacturerId}");
            
            if(isset($modelsMap[$lower])){
                return $modelsMap[$lower];
            }
            else{
                $model = new CarModel();
                $model->model = $title;
                $model->full_name = $title;
                $model->year = $year;
                $model->manufacturer_id = $manufacturerId;
                $model->save();
                
                $modelsMap[$lower] = $model->id;
                
                return $modelsMap[$lower];
            }
            
        };
        function getManufacturer($name,&$manufacturerMap){
            $nameLower = strtolower($name);
//            
            if(!isset($manufacturerMap[$nameLower])){
                $manufacturer = new Manufacturer();
                $manufacturer->name = $name;
                $manufacturer->save();
                $manufacturerMap[$nameLower] = $manufacturer->id;
            }
//            
            return $manufacturerMap[$nameLower];
        };
        
        
        $cars = Car::whereRaw('(update_hash is null or updated_at < ?) and source = ?',[
            date('Y-m-d H:i:s', strtotime('-3 hours')),
            Car::SOURCE_CARGURU
        ])->get();

        $options = [
            'http' => [
                'method' => 'GET',
                'ignore_errors' => true,
            ]
        ];

        $context = stream_context_create($options);

        foreach ($cars as &$carItem) {
            
            $id = (int) filter_var($carItem->url, FILTER_SANITIZE_NUMBER_INT);
            $url = 'https://www.cargurus.com/Cars/detailListingJson.action?inventoryListing=' . $id;

            try {
                $json = file_get_contents($url, false, $context);
                $hash = sha1($json);
                
                if($carItem->update_hash == $hash){
                    continue;
                }
                
                $res = json_decode($json, true);

                if (isset($res['listing']['price'])) {
                    $carItem->price = (int) $res['listing']['price'];
                }
                
                if (isset($res['listing']['vin'])) {
                    $carItem->vincode =  $res['listing']['vin'];
                }

                if (isset($res['listing']['msrp'])) {
                    $carItem->msrp = (int) $res['listing']['msrp'];
                }

                if (isset($res['listing']['year'])) {
                    $carItem->year = $res['listing']['year'];
                }
                
                
                if (isset($res['listing']['listingTitle'],$res['listing']['year'])) {
                    
//                    $carItem->model = $res['listing']['listingTitle'];
                    $manufacturerId = getManufacturer($res['listing']['listingTitle'], $manufacturerMap);   
                    $carItem->model_id = getModel($res['listing']['year'], $res['listing']['listingTitle'], $manufacturerId, $modelsMap);
                    $carItem->manufacturer_id = $manufacturerId;
                }
                
                
                
                

              

                if (isset($res['seller'])) {
                    $carItem->diller_id = getDealer($res['seller'],$dealersMap);
                    
                }
                
                
                

                $carItem->update_hash = $hash;
                
                unset($id, $json, $url,$hash);
                
                
                $properties = [];

                 $optionValuesData = [
                    'car_id' => $carItem->id,
                ];   
                 
                if (isset($res['listing']['localizedEngineDisplayName'])) {
                    $properties['engine_name'] = $res['listing']['localizedEngineDisplayName'];

                    if (preg_match('/\d.\d/', $res['listing']['localizedEngineDisplayName'], $matches)) {
                        $optionValuesData['engine_volume'] = $matches[0];
                    }

                    if (preg_match('/\d+\shp/', $res['listing']['localizedEngineDisplayName'], $matches)) {
                        $properties['engine_power'] = $res['listing']['localizedEngineDisplayName'];
                    }
                }
                
                if (isset($res['listing']['mileage'])) {
                    $optionValuesData['odo'] = $res['listing']['mileage'];
                    $optionValuesData['odo_class'] = Car::getOdoClassByOdo($optionValuesData['odo']);   
                }
                else{
                    $optionValuesData['odo'] = null;
                }
                
                if (isset($res['listing']['localizedExteriorColor'])) {
                    $optionValuesData['color'] = $res['listing']['localizedExteriorColor'];
                }

                if (isset($res['listing']['combinedFuelEconomy']['value'])) {
                    $optionValuesData['MGP'] = $res['listing']['combinedFuelEconomy']['value'];
                }

                if (isset($res['listing']['localizedFuelType'])) {
                    $properties['fuel_type'] = $res['listing']['localizedFuelType'];
                }

                if (isset($res['listing']['localizedDriveTrain'])) {
                    $properties['drivetrain'] = $res['listing']['localizedDriveTrain'];
                }

                if (isset($res['listing']['localizedInteriorColor'])) {
                    $properties['interior_color'] = $res['listing']['localizedInteriorColor'];
                }

                if (isset($res['listing']['localizedTransmission'])) {
                    $properties['transmission'] = $res['listing']['localizedTransmission'];
                }

                if (isset($res['listing']['fuelTankCapacity']) && count($res['listing']['fuelTankCapacity']) > 0) {
                    $properties['fuel_tank_capacity'] = $res['listing']['fuelTankCapacity'];
                }

                if (isset($res['listing']['localizedNumberOfDoors'])) {
                    $properties['number_of_doors'] = $res['listing']['localizedNumberOfDoors'];
                }

                if (isset($res['listing']['localizedCargoVolume'])) {
                    $properties['cargo_volume'] = $res['listing']['localizedCargoVolume'];
                }

                DB::table('options_values')->insert($optionValuesData);
                
                if(isset($res['listing']['pictures'])){
                    
                    DB::table('car_images')->insert(array_map(function($item) use(&$carItem){
                        return [
                            'src' => $item['url'],
                            'car_id' => $carItem->id
                        ];
                    }, $res['listing']['pictures']));
                    
                    
                    $carItem->main_image = $res['listing']['pictures'][0]['url'];

                }
                
                if (!empty($properties)) {
                    $carItem->setPropertiesAttribute($properties);
                }

                
                if(isset($res['listing']['vehicleHistory'])){
                    
                    $carItem->is_traffic_accident = isset($res['vehicleHistory']['accidentCount']) ? $res['vehicleHistory']['accidentCount'] > 0 : null;
                    $carItem->number_of_owners = $res['vehicleHistory']['ownerCount'] ?? 1;
                }
                else{
                    $carItem->is_traffic_accident = null;
                    $carItem->number_of_owners = 1;
                }
                
                
                $carItem->save();
                
            } catch (\Exception $ex) {
                echo 'Line: ', $ex->getLine(), PHP_EOL;
                echo 'Message: ', $ex->getMessage(), PHP_EOL;
//                echo 'Header: ', implode(PHP_EOL, $http_response_header),PHP_EOL;
                continue;
            }

            unset($res, $optionValuesData);
        }
        
        echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
    }

    private function getProxy() {
        
    }
    
    
    private function normilizaManufacturers($manufacturerMap){
        
        foreach(array_unique($manufacturerMap) as $id => $name){
            
            $ids = array_column(DB::table('manufacturers')->select('id')->where('name','like',$name)->get()->toArray(),'id');
            $res =  DB::table('cars')->whereIn('manufacturer_id',$ids)->update(['manufacturer_id' => $id]);
            $position = array_search($id, $ids);
            
            if(isset($ids[$position])){
                unset($ids[$position]);
            }
            
            DB::table('manufacturers')->whereIn('id',$ids)->delete(); 
        }
        
    }

}
