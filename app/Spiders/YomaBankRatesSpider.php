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
use Symfony\Component\DomCrawler\Crawler;

class YomaBankRatesSpider extends BasicSpider
{
    const BANKURL = 'https://www.yomabank.com/mm/personal/rates';
    const BANKNAME = 'yoma_bank';

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
        Log::error('Hit to YomaBankRatesSpider@parse');

        $bodytext = $response->text();
        $bank = $response->filter('title')->text();


        //<h1 class="mod-smmaintit mb3">
        //Digital Rates
        //<span class="exrate-date">Jan 10, 2023 (Tuesday) • 09:45 AM</span>
        //</h1>
        $updated_datetime = $response->filterXPath('//h1[contains(@class, "mod-smmaintit mb3")]/span[contains(@class, "exrate-date")]')->text();

        //<table class="table">
        //<tbody>
        //<tr>
        //<td th="" scope="row" class="currency-name tb-tit">Currency</td>
        //<td class="refrate tb-tit">Ref; Rate</td>
        //<td class="buyrate tb-tit">Buy</td>
        //<td class="sellrate tb-tit">Sell</td>
        //</tr>
        //<tr>
        // <th scope="row" class="currency-name">
        //<figure class="currency-icon">
        //<img src="https://www.yomabank.com/storage/images/currency/scale-m3/x5nSFG6431SgEqnFDCyi-20180911110659.jpg" alt="Yoma Bank">
        //</figure>
        //<span>USD</span>
        //</th>
        //<td class="refrate">2100</td>
        //<td class="buyrate">2105</td>
        //<td class="sellrate">2106</td>
        //</tr>
        //<tr>
        //<th scope="row" class="currency-name">
        //<figure class="currency-icon">
        //<img src="https://www.yomabank.com/storage/images/currency/scale-m3/iZhvO5SPc6vNyFRQLgd8-20180911110706.jpg" alt="Yoma Bank">
        //</figure>
        //<span>EUR</span>
        //</th>
        //<td class="refrate">2240.6</td>
        //<td class="buyrate">2234</td>
        //<td class="sellrate">2247</td>
        //</tr>
        //<tr>
        //<th scope="row" class="currency-name">
        //<figure class="currency-icon">
        //<img src="https://www.yomabank.com/storage/images/currency/scale-m3/NAM3Ot9xA16Yui0Lkoe0-20180911110712.jpg" alt="Yoma Bank">
        //</figure>
        //<span>SGD</span>
        //</th>
        //<td class="refrate">1575.5</td>
        //<td class="buyrate">1571</td>
        //<td class="sellrate">1580</td>
        //</tr>
        //</tbody>
        //</table>
        //Find the second occurrence of the table->tbody = eq(1)
        $exchangenodes = $response->filterXPath('//table[contains(@class, "table")]/tbody')->eq(1)->children();
        Log::error('Node Count  - ' . count($exchangenodes));
        foreach ($exchangenodes as $node) {

            $nodeCrawler = new Crawler($node);
            Log::error('Next Node Name  - ' . $nodeCrawler->nodeName());

            $currencyNodeCrawlers = $nodeCrawler->children();
            $tmparray = [];
            $index = 'Default';
            foreach ($currencyNodeCrawlers as $currnode) {
//
                $currNodeCrawler = new Crawler($currnode);
                Log::error('Base Node Class  - ' . $currNodeCrawler->nodeName());
                Log::error('Base Node Text - ' . $currNodeCrawler->text());
//
                //Build the array
                if (in_array($currNodeCrawler->text(), ['USD', 'SGD'])) {
                    //Set the index
                    $index = $currNodeCrawler->text();
                } else {
                    $tmparray[$index][$currNodeCrawler->attr('class')] = $currNodeCrawler->text();
                }
            }

            //Only if temp array is USD or SGD
            if ($index != 'Default') {
                $currencyarray[] = $tmparray;
            }

        }

        Log::error('currency array - ' . json_encode($currencyarray));
        //[{"USD":{"refrate":"2100","buyrate":"2105","sellrate":"2106"}},{"SGD":{"refrate":"1575.5","buyrate":"1571","sellrate":"1580"}}]
        $buyusd = $currencyarray[0]['USD']['buyrate'];
        $sellusd = $currencyarray[0]['USD']['sellrate'];
        $buysgd = $currencyarray[1]['SGD']['buyrate'];
        $sellsgd = $currencyarray[1]['SGD']['sellrate'];


        Log::error('Bank@parse - ' . $bank);
        Log::error('updated_datetime@parse - ' . $updated_datetime);
        Log::error('buyusd@parse - ' . $buyusd);
        Log::error('sellusd@parse - ' . $sellusd);
        Log::error('buysgd@parse - ' . $buysgd);
        Log::error('sellsgd @parse- ' . $sellsgd);

        //Update the rate to DB
        $page = new Page();
        $page->update_bank_rates(self::BANKNAME, $buyusd, $sellusd, $buysgd, $sellsgd, $updated_datetime);
//
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
