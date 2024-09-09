<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;
use App\Dealer;

/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseCarsDealers extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:cars-dillers';

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
        
         function hundler($dealer,&$client) {
            
             echo $dealer->id,PHP_EOL;
            
            $url = 'https://www.cars.com/dealers/' . $dealer->id;

            
            $crawler = $client->request('GET',$url);
            
            if ($client->getInternalResponse()->getStatusCode() == 200) {
                
               $item = $crawler->filter('script[type="application/ld+json"]')->eq(1);
               $objectInfo = json_decode(trim($item->html()),true);
               
               $dealer->geo_lat = $objectInfo['geo']['latitude'];
               $dealer->geo_long = $objectInfo['geo']['longitude'];
               $dealer->name = $objectInfo['name'];
               
               $dealer->hash = md5($objectInfo['name']);
               $dealer->address = implode(', ', $objectInfo['address']);
               $dealer->url = $objectInfo['url'] ?? null;
               $dealer->source = Dealer::SOURCE_CARS;
               $dealer->update();
                
                
            }
        };

        $client = new CustomClient([
            'http_version' => '2.0',
        ]);
        $dealers = Dealer::distinct()->where('geo_lat',null)->get();
        
        foreach($dealers as &$dealer){    
            hundler($dealer,$client);
        }
        
        return 0;
        
        
        
    }

}
