<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\DB;

use App\{
    Option,
    OptionValue,
    Car
};

/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseCarsOptions extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:cars-options';

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
       
//        $cars = DB::select('select id,url from cars where is_options_set = :opt_set LIMIT 250', ['opt_set' => 0]);
        $cars = Car::where('is_options_set',0)->limit(200)->get();
        
        $domain = 'https://www.cars.com';
        $client = new CustomClient([
            'http_version' => '2.0',
        ]);
        
        $carsIds = [];

        foreach ($cars as &$carItem) {

            $crawler = $client->request('GET', $domain . $carItem->url);

            try {
                if ($client->getInternalResponse()->getStatusCode() == 200) {
                    $this->getCarOptions($crawler, $carItem);
                }
            } catch (\Exception $ex) {
                echo $ex->getMessage(), PHP_EOL, PHP_EOL, PHP_EOL;   
            }
        }
        

        return 0;
    }

    public function getCarOptions(&$itemCrawler, &$carItem) {
        $data =  $optionValuesData = $keys = $values = [];
      
        $itemCrawler->filter('dl.fancy-description-list')->each(function ($node) use(&$keys, &$values) {
            $i = 0;
            $node->children()->each(function ($node) use(&$keys, &$values, &$i) {
                $html = strip_tags($node->outerHtml());

                if ($i & 1) {
                    $values[] = trim($html);
                } else {
                    $keys[] = trim($html);
                }
                $i++;
            });
        });
        
        $optionValuesData = [
            'car_id' => $carItem->id,
        ];   
        
//        $itemCrawler->filter('ul.all-features-list')->each(function ($node)  use(&$optionValuesData,&$carItem,&$optionsMap) {
//            $features = [];
//            
//            $node->children()->each(function ($node) use(&$features) {
//                $features[] = $node->text();
//            });
//            
//            if(!empty($features)){
               
//            }
//        });
//
        
        
        $data['options'] = \array_combine($keys, $values);
        
        $properties = [];
        
        if (isset($data['options']['Transmission'])) {
            $properties['transmission'] = $data['options']['Transmission'];           
        } 
       
        if (isset($data['options']['Engine']) && \preg_match('/\d[.]\dL/', $data['options']['Engine'], $matches)) {
            $properties['engine'] = $data['options']['Engine'];
            $optionValuesData['engine_volume'] = floatval($matches[0]);   
        }
//
        if (isset($data['options']['Drivetrain'])) {
            $properties['drivetrain'] = $data['options']['Drivetrain'];           
        }
//        
        if (isset($data['options']['Fuel type'])) {
            $properties['fuel_type'] = $data['options']['Fuel type'];
        }
//        
        if (isset($data['options']['Interior color'])) {
            $properties['interior_color'] = $data['options']['Interior color'];
        }
        
        if (isset($data['options']['Mileage']) && !empty($data['options']['Mileage'])) {
            $optionValuesData['odo'] = preg_replace('/\D/','',$data['options']['Mileage']); 
            $optionValuesData['odo_class'] = Car::getOdoClassByOdo($optionValuesData['odo']);
            
        }
        else{
            $optionValuesData['odo'] = null; 
        }
        
        if (isset($data['options']['Exterior color'])) {
            $optionValuesData['color'] = $data['options']['Exterior color'];
        }
        
        $mpg = $itemCrawler->filter('.sds-tooltip > span');
        
        if($mpg->count() > 0){
            preg_match_all('/\d+/', $itemCrawler->filter('.sds-tooltip > span')->text(), $matches);
            
            if(count($matches[0]) > 1){
                $optionValuesData['MGP'] = floor(array_sum($matches[0]) / count($matches[0]));
            }
            else{
                $optionValuesData['MGP'] = $matches[0];
            }
        }
        
        if(!empty($properties)){
            $carItem->setPropertiesAttribute($properties);
        }
        
        if (isset($data['options']['VIN'])) {
            $carItem->vincode = $data['options']['VIN'];
        }
        
        $carItem->is_options_set = 1;
        $carItem->save();
        
        DB::table('options_values')->insert($optionValuesData);
    }

}
