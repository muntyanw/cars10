<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseAutotrader extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:autotrader-item';

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
        $time_start = microtime(true); 

        
        $url = '/shopping/results/?page_size=100&zip=60606';
        $domain = 'https://www.cars.com';


        $client = new CustomClient([
            'http_version' => '2.0',
        ]);
        
        $crawler = $client->request('GET','https://www.autotrader.com/cars-for-sale/vehicledetails.xhtml?listingId=669413333&clickType=recommendations');

        $currentPage = 1;

        $html = $crawler->html();
        
        file_put_contents('autotrade_item.html', $html);
        return 0;
        
        
        
    }

}
