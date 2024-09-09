<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Components\Parser\CustomClient;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;
use App\Car;
/**
 * Description of ParseCars
 *
 * @author alexp
 */
class ParseCarsGetUrls extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:cars-get-urls';

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
        
        $currentPage = 1;

        function hundler($url,&$client,&$domain, &$currentPage) {
            $crawler = $client->request('GET',$domain . $url);
            
            if ($client->getInternalResponse()->getStatusCode() == 200) {
                $urls = [];
                
                $crawler->filter('.vehicle-card-link')->each(function ($node,$i) use(&$urls,&$url,&$currentPage) {
                    
                    $urls[] = [
                        'is_options_set' => false,
                        'source' => Car::SOURCE_CARS,
                        'url' => $node->attr('href'),
                        'list_url_source' => $url,
                        'position_on_page' => $i + 1,
                        'page_number' => $currentPage,
                    ];
                });

                DB::table('cars')->insert($urls);
                
                $lastRef = $crawler->filter('li.sds-pagination__item > a')->last();
                $nextPage = (int)$lastRef->attr('phx-value-page');
                $href = $lastRef->attr('href');
                
                if($nextPage > $currentPage){
                    $currentPage = &$nextPage;
                    unset($lastRef,$nextPage,$crawler);
                    hundler($href,$client,$domain, $currentPage);
                }
            }
            else{
                echo $domain . $url,PHP_EOL;
            }
            
        };

        hundler($url,$client,$domain, $currentPage);
        
        echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
        
        return 0;
        
        
        
    }

}
