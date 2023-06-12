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

class ABankRatesSpider extends BasicSpider
{
    const BANKURL = 'https://www.abank.com.mm/en_US/';
    const BANKNAME = 'a-bank';

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
        Log::error('Hit to ABankRatesSpider@parse');

        $bodytext = $response->text();
        $bank =  $response->filter('title')->text();

        //<div class="day-time">
        //            Exchange Rate  09-01-2023 <span class="time-line"> 09:00 AM</span>
        //          </div>
        $updated_datetime_raw =  $response->filterXPath('//div[contains(@class, "day-time")]')->text();


        //$test =  $response->filterXPath('//li[contains(@class, "slideItem")]/img[contains(@src, "https://www.abank.com.mm/wp-content/themes/hestia/assets/img/SGD_24.png")]')->first();

        //<div class="slider-exchange-rate">
        //          <!-- <div class="edge"></div> -->
        //            <ul class="slideContainer" id="money_start" style="margin-left: -19.1042px;">
        //
        //
        //
        //
        //                <!-- <li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/THD_24.png"> Buy  - : Sell  -                </li> -->
        //
        //
        //
        //
        //               <!-- <li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/THD_24.png"> Buy  - : Sell  -                </li> -->
        //
        //
        //
        //                <li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/SGD_24.png"> Buy 1558 : Sell 1563                </li><li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/MYR_24.png"> Buy 476 : Sell 478                </li><li class="slideItem">
        //                        <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/USD_24.png"> Buy 2103 : Sell 2106                </li><li class="slideItem">
        //                  <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/EUR_24.png"> Buy 2206 : Sell 2213                </li><li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/SGD_24.png"> Buy 1558 : Sell 1563                </li><li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/MYR_24.png"> Buy 476 : Sell 478                </li><li class="slideItem">
        //                        <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/USD_24.png"> Buy 2103 : Sell 2106                </li><li class="slideItem">
        //                  <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/EUR_24.png"> Buy 2206 : Sell 2213                </li><li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/SGD_24.png"> Buy 1558 : Sell 1563                </li><li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/MYR_24.png"> Buy 476 : Sell 478                </li><li class="slideItem">
        //                        <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/USD_24.png"> Buy 2103 : Sell 2106                </li><li class="slideItem">
        //                  <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/EUR_24.png"> Buy 2206 : Sell 2213                </li>
        //                <!-- <li class="slideItem">
        //                    <img class="slide-logo" src="https://www.abank.com.mm/wp-content/themes/hestia/assets/img/THD_24.png"> Buy  - : Sell  -                </li> -->
        //
        //            </ul>
        //        </div>

        //USD
        $buysellusd =  $response->filterXPath('//li[contains(@class, "slideItem")]')->text();

        //SGD
        $usditem =  $response->filterXPath('//li[contains(@class, "slideItem")]/img[contains(@src, "https://www.abank.com.mm/wp-content/themes/hestia/assets/img/SGD_24.png")]')->ancestors();
        $buysellsgd =  $usditem->text();


        //String operation
        //Exchange Rate 09-01-2023 09:00 AM
        $updated_datetime = Str::after($updated_datetime_raw, 'Exchange Rate ');

        //Buy 2103 : Sell 2106
        $buyusd = last(explode(" ",Str::before($buysellusd, ' :')));
        $sellusd = last(explode(" ",Str::after($buysellusd, ':')));

        //Buy 2103 : Sell 2106
        $buysgd = last(explode(" ",Str::before($buysellsgd, ' :')));
        $sellsgd = last(explode(" ",Str::after($buysellsgd, ':')));

        Log::error('Bank@parse - '.$bank);
        Log::error('buysellusd@parse - '.$buysellusd);
        Log::error('buysellsgd@parse - '.$buysellsgd);
        Log::error('updated_datetime@parse - '.$updated_datetime);
        Log::error('buyusd@parse - '.$buyusd);
        Log::error('sellusd@parse - '.$sellusd);
        Log::error('buysgd@parse - '.$buysgd);
        Log::error('sellsgd @parse- '.$sellsgd);


        //Update the rate to DB
        $page = new Page();
        $page->update_bank_rates(self::BANKNAME,$buyusd,$sellusd,$buysgd,$sellsgd,$updated_datetime);


        yield $this->item([
            'bank' => $bank,
//            'updated_datetime' => $updated_datetime,
//            'buyusd' => $buyusd,
//            'buysgd' => $buysgd,
//            'sellusd' => $sellusd,
//            'sellsgd' => $sellsgd,
        ]);
    }

}
