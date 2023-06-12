<?php

namespace App\Spiders;

use App\Models\Page;
use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class CBBankRatesSpider extends BasicSpider
{
    const BANKURL = 'https://www.cbbank.com.mm/en';
    const BANKNAME = 'cb_bank';

    public array $startUrls = [
        //
        self::BANKURL
    ];

    /**
     * How many requests are allowed to be sent concurrently.
     */
    public int $concurrency = 2;

    /**
     * The delay (in seconds) between requests. Note that there
     * is no delay between concurrent requests. Instead, Roach
     * will wait for the `$requestDelay` before sending the
     * next "batch" of concurrent requests.
     */
    public int $requestDelay = 2;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        // todo...
        Log::error('');
        Log::error('Hit to CBBankRatesSpider@parse');

        $bodytext = $response->text();
        $bank =  $response->filter('title')->text();

        //<span class="date-display-single" property="dc:date" datatype="xsd:dateTime" content="2023-01-10T09:25:00+06:30">10/01/2023 - 09:25 AM</span>
        $updated_datetime =  $response->filterXPath('//span[contains(@class, "date-display-single")]')->text();

        Log::error('Bank@parse - '.$bank);
        Log::error('updated_datetime@parse - '.$updated_datetime);

        //USD
        //<div class="currency-exchange">
        //	<div class="currency-info">
        //		<div class="currency-type">Currency</div>
        //		<div class="currency-buy">Buy</div>
        //		<div class="currency-sell">Sell</div>
        //	</div>
        //	<div class="currency-info">
        //		<div class="currency-type">USD</div>
        //		<div class="currency-buy">2104.3 </div>
        //		<div class="currency-sell">2106.3</div>
        //	</div>
        //	<div class="currency-info">
        //		<div class="currency-type">EUR</div>
        //		<div class="currency-buy">2244.3 </div>
        //		<div class="currency-sell">2247.3 </div>
        //	</div>
        //	<div class="currency-info">
        //		<div class="currency-type">SGD</div>
        //		<div class="currency-buy">1577.2 </div>
        //		<div class="currency-sell"> 1580.2 </div>
        //	</div>
        //	<div class="currency-info">
        //		<div class="currency-type">THB</div>
        //		<div class="currency-buy">64</div>
        //		<div class="currency-sell">66 </div>
        //	</div>
        //	<div class="currency-info">
        //		<div class="currency-type">MYR</div>
        //		<div class="currency-buy">480.4</div>
        //		<div class="currency-sell">481.4 </div>
        //	</div>
        // 	<div class="update-date">Updated on <span class="date-display-single" property="dc:date" datatype="xsd:dateTime" content="2023-01-10T09:25:00+06:30">10/01/2023 - 09:25 AM</span></div>
        // 	<div class="edit-link"> </div>
        //</div>
        $exchangenodes =  $response->filterXPath('//div[contains(@class, "currency-exchange")]')->children();
//        Log::error('Node Count  - '.count($exchangenodes));
        foreach ($exchangenodes as $node) {

            $nodeCrawler = new Crawler($node);
//            $nodecurrency = $nodeCrawler->filterXPath('//div[contains(@class, "currency-type")]')->text();
//            Log::error('Next Node Class  - '.$nodeCrawler->attr('class'));

            $currencyNodeCrawlers = $nodeCrawler->children();
            $tmparray = [];
            $index = 'Default';
            foreach ($currencyNodeCrawlers as $currnode) {

                $currNodeCrawler = new Crawler($currnode);
//                Log::error('Base Node Class  - '.$currNodeCrawler->attr('class'));
                Log::error('Base Node Text - '.$currNodeCrawler->text());

                //Build the array
                if(in_array($currNodeCrawler->text(), ['USD','SGD'])) {
                    //Set the index
                    $index = $currNodeCrawler->text();
                } else {
                    $tmparray[$index][$currNodeCrawler->attr('class')] = $currNodeCrawler->text();
                }
            }

            //Only if temp array is USD or SGD
            if($index != 'Default') {
                $currencyarray[] = $tmparray;
            }


        }

//        Log::error('currency array - '.json_encode($currencyarray));
        //[{"USD":{"currency-buy":"2104.3","currency-sell":"2106.3"}},{"SGD":{"currency-buy":"1577.2","currency-sell":"1580.2"}}]
        $buyusd = $currencyarray[0]['USD']['currency-buy'];
        $sellusd = $currencyarray[0]['USD']['currency-sell'];
        $buysgd = $currencyarray[1]['SGD']['currency-buy'];
        $sellsgd = $currencyarray[1]['SGD']['currency-sell'];


        Log::error('buyusd@parse - '.$buyusd);
        Log::error('sellusd@parse - '.$sellusd);
        Log::error('buysgd@parse - '.$buysgd);
        Log::error('sellsgd @parse- '.$sellsgd);


        //Update the rate to DB
        $page = new Page();
        $page->update_bank_rates(self::BANKNAME,$buyusd,$sellusd,$buysgd,$sellsgd,$updated_datetime);


        yield $this->item([
            'bank' => $bank,
            'updated_datetime' => $updated_datetime,
            'buyusd' => $buyusd,
            'buysgd' => $buysgd,
            'sellusd' => $sellusd,
            'sellsgd' => $sellsgd,
        ]);
    }

}
