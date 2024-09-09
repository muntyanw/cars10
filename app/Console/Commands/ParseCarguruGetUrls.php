<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use Illuminate\Support\Facades\DB;
/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseCarguruGetUrls extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:carguru-get-urls';

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
        $url = 'https://www.cargurus.com/Cars/new/searchresults.action?sourceContext=carGurusHomePagePrice&inventorySearchWidgetType=PRICE&minPrice=1000&maxPrice=200000&zip=61032#resultsPage=1';


        $client = new CustomClient([
            'http_version' => '2.0',
        ]);

        $currentPage = 1;

        function hundler($url, &$client, &$currentPage) {
            echo $currentPage,PHP_EOL;
            
            $crawler = $client->request('GET', $url);

            if ($client->getInternalResponse()->getStatusCode() == 200) {
                $urls = [];

                $crawler->filter('a[href^="#listing"]')->each(function ($node,$i) use(&$urls,&$url,&$currentPage) {

                    $urls[] = [
                        'is_options_set' => false,
                        'source' => \App\Car::SOURCE_CARGURU,
                        'url' => $node->attr('href'),
                        'list_url_source' => $url,
                        'position_on_page' => $i + 1,
                        'page_number' => $currentPage,
                    ];
                    
                });

                DB::table('cars')->insert($urls);

                $html = $crawler->html();
                preg_match('/"totalListings":\d+/', $html, $matches);
                $total = ceil(
                    (int) filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT)
                    /
                    15
                ) ;

                if ($total > $currentPage) {
                    $newPage = $currentPage + 1;
                    $url = str_replace('resultsPage=' . $currentPage, 'resultsPage=' . $newPage, $url);
                    unset($crawler,$urls,$currentPage,$matches,$total,$html);
                    hundler($url, $client, $newPage);
                }
            }
        }
        
        hundler($url, $client, $currentPage);

        return 0;
    }

}
