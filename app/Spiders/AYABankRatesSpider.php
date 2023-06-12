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

class AYABankRatesSpider extends BasicSpider
{
    const BANKURL = 'https://www.ayabank.com/en_US/';
    const BANKNAME = 'aya_bank';

    public array $startUrls = [
        //
        self::BANKURL
    ];

    /**
     * The downloader middleware that should be used for
     * runs of this spider.
     */
    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    /**
     * The spider middleware that should be used for runs
     * of this spider.
     */
    public array $spiderMiddleware = [
        //
    ];

    /**
     * The item processors that emitted items will be send
     * through.
     */
    public array $itemProcessors = [
        //
    ];

    /**
     * The extensions that should be used for runs of this
     * spider.
     */
    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
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
        Log::error('Hit to AYABankRatesSpider@parse');

        $bodytext = $response->text();
        $bank =  $response->filter('title')->text();

        //<tr class="row-1">
        //<td rowspan="2" class="column-1"><span style="color:#a02225;font-size:16px;font-weight:bold">EXCHANGE RATE</span></td><td class="column-2"></td><td rowspan="2" class="column-3">9<sup>th</sup> Jan 2023 <br>
        //<small><b>( 09:52 AM   )</b></small></td>
        $updated_datetime =  $response->filterXPath('//tr[contains(@class, "row-1")]/td[contains(@class, "column-3")]')->text();

        //<td class="column-6"><b style="color:#5463FF">BUY</b>   2105</td>
        $buyusd =  $response->filterXPath('//tr[contains(@class, "row-1")]/td[contains(@class, "column-6")]')->text();

        //<td class="column-12"><b style="color:#5463FF">BUY</b>  1558</td>
        $buysgd =  $response->filterXPath('//tr[contains(@class, "row-1")]/td[contains(@class, "column-12")]')->text();


        $sellusd =  $response->filterXPath('//tr[contains(@class, "row-2")]/td[contains(@class, "column-6")]')->text();
        $sellsgd =  $response->filterXPath('//tr[contains(@class, "row-2")]/td[contains(@class, "column-12")]')->text();


        Log::error('Bank@parse - '.$bank);
        Log::error('updated_datetime@parse - '.$updated_datetime);
        Log::error('buyusd@parse - '.$buyusd);
        Log::error('buysgd@parse - '.$buysgd);
        Log::error('sellusd@parse - '.$sellusd);
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
