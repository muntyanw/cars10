<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use Illuminate\Support\Facades\DB;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use App\{
    Car,
    OptionValue,
    Dealer
};
/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseTrueCarsGetItems extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:truecars-get-items';

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
    public function handle()
    {
        
//        function getDealer($sellerInfo,&$dealersMap){
//            
//            $externalId =  $sellerInfo['listingSellerId'];
//            
//            if(!isset($dealersMap[$externalId])){
//                $geo = $sellerInfo['address']['geo'];
//                
//                $dealer = new Dealer();
//                $dealer->hash = md5($sellerInfo['name']);
//                $dealer->name = $sellerInfo['name'];
//                $dealer->import_id = $externalId;
//                $dealer->address = implode(', ', $sellerInfo['address']['addressLines']);
//                $dealer->geo_lat = $geo['latitude'];
//                $dealer->geo_long = $geo['longitude'];
//                $dealer->url = $sellerInfo['websiteDomain'];
//                $dealer->source = Dealer::SOURCE_CARGURU;
//                
//                
//                $dealer->save();
//                
//                $dealersMap[$externalId] = $dealer->id;
//                
//            }
//            
//            return $dealersMap[$externalId];
//            
//        }
//        
        $cars = Car::where('source',Car::SOURCE_TRUECAR)
                ->where('update_hash',null)
                ->take(500)
                ->get();
        
        $browser = new HttpBrowser(HttpClient::create());
        
        foreach($cars as $carItem){
            
            $url = 'https://www.truecar.com/' . $carItem->url;
            $modelId = $manufacturerId = $year = $engineVolume = $color = $transmission = $fuelType = $driveType = $engine  = $odo = $mainImage = $vincode = $owners = $accident = $price = null;
            $odoClass = Car::ODO_CLASS_UNDEFINED;
            $mpg = 0;
            $properties = [];
            

            $crawler = $browser->request('GET', $url);
            $priceHtml = $crawler->filter('div.heading-2.mt-1');

            if ($priceHtml->count() > 0) {
                $price = preg_replace('/\D+/', '', $priceHtml->text());;
            }

            $accidentHtml = $crawler->filter('.heading-base.mt-1');
            if ($accidentHtml->count() > 0) {
                $accident = $accidentHtml->eq(0)->text();
            }

            $ownersHtml = $crawler->filter('.heading-base.mt-1');
            if ($ownersHtml->count() > 0) {
                $owners = $ownersHtml->eq(1)->text();;
            }
            
            $vincodeHtml = $crawler->filter('p[data-test="vinNumber"]');
            if ($vincodeHtml->count() > 0) {
                $vincode = $vincodeHtml->eq(0)->text();;
            }
            
            $imgHtml = $crawler->filter('img[class="img-inner img-block"][sizes="600px"]');
            if ($imgHtml->count() > 0) {
                $mainImage = $imgHtml->attr('src');;
            }
            
            $odoHtml = $crawler->filter('span.flex.items-center')->eq(0);
            if ($odoHtml->count() > 0) {
                
                if(preg_match('/[0-9,]+\smile/',$odoHtml->text(),$matches)){
                    $odo = str_replace([',',' ','mile'], '', $matches[0]);
                    $odoClass = Car::getOdoClassByOdo($odo);
                }
                
     
            }
            
            $colorHtml = $crawler->filter('p[class="text-base"]')->eq(1);
            if ($colorHtml->count() > 0) {
                $color = $colorHtml->text();;
            }
            
            $mpgHtml = $crawler->filter('p[class="text-base"]')->eq(3);
         
            
            if ($mpgHtml->count() > 0) {
                $tmp = $mpgHtml->text();
                $mpg = preg_replace('/\D+/', '', explode('/',$tmp)[0]);
            }
            
            $engineHtml = $crawler->filter('p[class="text-base"]')->eq(4);
            
            if ($engineHtml->count() > 0) {
                $engine = $engineHtml->text();
                if(preg_match('/\d\.\d/',$engine,$matches)){
                    $engineVolume = $matches[0];
                }
            }
            
            
            $fullNameHtml = $crawler->filter('.heading-3_5.heading-md-2.mb-1')->eq(0);
            
            if ($fullNameHtml->count() > 0) {
                $exploded = explode(' ',$fullNameHtml->text());
                $year = $exploded[0];
                $manufacturer = $exploded[1];
                unset($exploded[0],$exploded[1]);
                $model = implode(' ',$exploded);   
            }
            
            
            $driveTypeHtml = $crawler->filter('p[class="text-base"]')->eq(5);
            if($driveTypeHtml->count() > 0){
                $properties['drivetrain'] = $driveTypeHtml->text();
            }
            
            $fuelTypeHtml = $crawler->filter('p[class="text-base"]')->eq(6);
            if($fuelTypeHtml->count() > 0){
                $properties['fuel_type'] = $fuelTypeHtml->text();
            }
            
            $transmissionHtml = $crawler->filter('p[class="text-base"]')->eq(7);
            if($transmissionHtml->count() > 0){
                $properties['transmission'] = $transmissionHtml->text();;
            }
            
            
            
            
            OptionValue::create([
                'car_id' => $carItem->id,
                'color' => $color,
                'odo' => $odo,
                'MGP' => $mpg,
                'engine_volume' => $engineVolume,
                'odo_class' => $odoClass
            ]);
            
            if(!empty($properties)){
                $carItem->setPropertiesAttribute($properties);
            }
            
            
//            $carItem->diller_id = getDealer($res['seller'],$dealersMap);
            
            $carItem->price = $price;
            $carItem->accident_count = $accident;
            $carItem->number_of_owners = $owners;
            $carItem->main_image = $mainImage;
            $carItem->vincode = $vincode;
            $carItem->update();
            
            unset($crawler);
        }
        
        return 0;
    }

}
