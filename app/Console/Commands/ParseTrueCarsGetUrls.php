<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use Illuminate\Support\Facades\DB;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use App\Car;
/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseTrueCarsGetUrls extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:truecars-get-urls';

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

        $url = 'https://www.truecar.com/used-cars-for-sale/listings/location-tampa-fl/';
        $browser = new HttpBrowser(HttpClient::create());
        $urls = $crawler = null;
        do{
            $urls = [];
        
        
          
            $crawler = $browser->request('GET', $url);

            $crawler->filter('a.linkable.vehicle-card-overlay.order-2')->each(function ($node,$i)  use(&$urls,&$url,&$currentPage) {

                $urls[] = [

                    'is_options_set' => false,
                    'source' => Car::SOURCE_TRUECAR,
                    'url' => $node->attr('href'),
                    'list_url_source' => $url,
                    'position_on_page' => $i + 1,
                    'page_number' => 1,
                ];
            });

            DB::table('cars')->insert($urls);
            
            $nextPageHtml = $crawler->filter('a[class="page-link"][data-test="Pagination-directional-next"]');
            if ($nextPageHtml->count() > 0) {
                $url = 'https://www.truecar.com'. $nextPageHtml->attr('href');;
                echo $url,PHP_EOL;
            }
            else{
                $url = false;
            }
            
            
            
        }
        while($url);
          
        
        
        
        return 0;
        
        
        
    }

}
