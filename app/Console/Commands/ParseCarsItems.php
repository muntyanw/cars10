<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use App\{
    Manufacturer,
    Car,
    CarModel,
    Dealer
};
use Illuminate\Support\Facades\DB;

/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseCarsItems extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:cars-items';

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
        
        $Dealers = Dealer::distinct()->get();
//        $mapDealers = 
                
        $DealersMap = $Dealers->mapWithKeys(function ($item) {
            return [$item['import_id'] => $item['id']];
        });
        
//        $modelsMap = DB::table('car_models')->selectRaw("LOWER(CONCAT(`model`,'_',`year`,'_',`manufacturer_id`)) as model,`id`")->pluck('id','model');;
        $modelsMap = DB::table('car_models')->selectRaw("LOWER(CONCAT(`model`,'_',`year`,'_',`manufacturer_id`)) as model,`id`")->pluck('id','model');;
        
        $manufacturerMap = [];
        foreach(Manufacturer::distinct()->get()->toArray() as $item){   
            $manufacturerMap[$item['id']] = strtolower($item['name']);
        }
        $this->normilizaManufacturers($manufacturerMap);
        
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
            $manName = explode(' ', $nameLower)[1];
            $res = array_search($manName,$manufacturerMap);
            
            if(!$res){
                $manufacturer = new Manufacturer();
                $manufacturer->name = ucfirst($manName);
                $manufacturer->save();
                $res = $manufacturer->id;
                $manufacturerMap[$res] = $manName;;
            }
            
            return $res;
        }       
        
        $domain = 'https://www.cars.com';
        $client = new CustomClient([
            'http_version' => '2.0',
        ]);
        
        $cars = Car::where('source',Car::SOURCE_CARS)
                ->where('update_hash',null)
                ->take(250)
                ->get();

        foreach ($cars as &$carItem) {

            $crawler = $client->request('GET', $domain . $carItem->url);
            $hash = sha1($crawler->html());
                
            if($carItem->update_hash == $hash){
                continue;
            }
            
            try {
                if ($client->getInternalResponse()->getStatusCode() == 200) {
                    
                    $title = $crawler->filter('div.dealer-address');
                    
                    if ($title->count() > 0) {
                        $title = $crawler->filter('.listing-title')->text();
                        $year = substr($title, 0, 4);
                        $title = str_replace($year,'', $title);;
                        $manufacturerId = getManufacturer($title, $manufacturerMap);   
                        
                        $carItem->year = $year;
                        $carItem->model_id = getModel($year, $title, $manufacturerId, $modelsMap);
                        $carItem->manufacturer_id = $manufacturerId;
                    }                  

                    $price = $crawler->filter('span.primary-price');

                    if ($price->count() > 0) {
                        $tmp = preg_replace('/\D+/', '', $price->text());
                        $carItem->price = empty($tmp) ? null : $tmp;   
                    }

                    $msrp = $crawler->filter('span.secondary-price');

                    if ($msrp->count() > 0) {
                        $carItem->msrp = preg_replace('/\D+/', '', $msrp->text());
                    }

                    $carItem->update_hash = $hash;
                    
                    $images = [];
                    
                    $crawler->filter('img.row-pic')->each(function ($node) use(&$images,&$carItem) {
                        $images[] = [
                            'src' => $node->attr('modal-src'),
                            'car_id' => $carItem->id,
                        ];
                    }); 
                    
                    if(count($images) > 0){
                        $carItem->main_image = $images[0]['src'];
                        DB::table('car_images')->insert($images);
                    }
                    
                    
                    $html = $crawler->html();
                    
                    if(preg_match('/"customer_id":"\d+"/', $html,$matches)){
                        $importId = preg_replace('/\D+/', '', $matches[0]);
                        $carItem->diller_id = Dealer::findByImportIdOrCreate($importId);
                        
                    }
                    
                    
                    $carItem->save();
                    
                }
            } catch (\Exception $ex) {
                echo $ex->getMessage(), PHP_EOL, PHP_EOL, PHP_EOL;
                echo $domain . $carItem->url, PHP_EOL;
               
            }
        }
        
        $this->normilizaManufacturers($manufacturerMap);

        return 0;
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
